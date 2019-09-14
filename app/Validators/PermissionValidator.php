<?php

namespace App\Validators;

use Prettus\Validator\LaravelValidator;

class PermissionValidator extends LaravelValidator
{
    protected $rules = [
        'name' => 'unique:permissions'
    ];
}