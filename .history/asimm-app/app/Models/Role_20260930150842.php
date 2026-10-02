<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasToMany;

class Role extends Model
{
    protected $fillable = ['name', 'label'];

}
