<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
    use HasFactory;

    protected $fillable = [
        'month','status','user_id'
    ];

    // relation
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
