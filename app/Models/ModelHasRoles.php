<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "model_has_roles";

    protected  $guarded = [];
}
