<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'store_categories');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
