<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLogModel extends Model
{
    use HasFactory;


    public $timestamps = true;
    protected $table ="files_log";
    protected $guarded = [];
}
