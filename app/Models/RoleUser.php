<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Model
{
    use HasFactory;

    protected $table = 'role_user';

    public $timestamps = false;
    protected $fillable = [
        'role_name','user_id','ability'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
