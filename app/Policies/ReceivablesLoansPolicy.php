<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Str;

class ReceivablesLoansPolicy
{
    public function __call($name, $arguments){
        $class_name = 'totals';
        if ($name == 'viewAny') {
            $name = 'view';
        }

        $ability = $class_name . '.' . Str::kebab($name);
        $user = $arguments[0];
        if ($user instanceof User) {
            return ($user->roles->where('role_name',$ability)->first() == null) ? false : true;
        }
    }
}
