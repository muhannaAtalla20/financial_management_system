<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Category;
use App\Models\Donation;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('categories', 'donations')->get();
        return view('stores.index', compact('stores'));
    }

    public function store(Request $request)
    {
        $store = Store::create($request->only(['name', 'location']));
        return redirect()->route('stores.index')->with('success', 'Store created successfully');
    }

    public function addCategory(Request $request, Store $store)
    {
        $category = Category::firstOrCreate(['name' => $request->name]);
        $store->categories()->attach($category->id);
        return redirect()->route('stores.show', $store->id)->with('success', 'Category added successfully');
    }

    public function addDonation(Request $request, Store $store)
    {
        $category = Category::firstOrCreate(['name' => $request->category_name]);
        $donation = Donation::create([
            'store_id' => $store->id,
            'category_id' => $category->id,
            'carton_quantity' => $request->carton_quantity,
            'item_quantity' => $request->item_quantity,
            'source' => $request->source,
        ]);
        return redirect()->route('stores.show', $store->id)->with('success', 'Donation added successfully');
    }

    public function getStoreDetails($id)
    {
        $store = Store::with('categories', 'donations')->findOrFail($id);
        return view('stores.show', compact('store'));
    }

    public function updateDonation(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $donation->update($request->only(['carton_quantity', 'item_quantity', 'source']));
        return redirect()->route('stores.show', $donation->store_id)->with('success', 'Donation updated successfully');
    }

    public function deleteDonation($id)
    {
        $donation = Donation::findOrFail($id);
        $storeId = $donation->store_id;
        $donation->delete();
        return redirect()->route('stores.show', $storeId)->with('success', 'Donation deleted successfully');
    }

    public function getStoreInventorySummary($id)
    {
        $store = Store::with('categories', 'donations')->findOrFail($id);
        $summary = $store->donations->groupBy('category_id')->map(function ($donations, $categoryId) {
            return [
                'category' => Category::find($categoryId)->name,
                'total_cartons' => $donations->sum('carton_quantity'),
                'total_items' => $donations->sum('item_quantity'),
            ];
        });

        return view('stores.inventory_summary', compact('store', 'summary'));
    }
}
