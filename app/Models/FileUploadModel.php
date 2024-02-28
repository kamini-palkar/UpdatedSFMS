<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileUploadModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;
    protected $table ="files";
    protected $guarded = [];
    
    public function project()
    {
        return $this->belongsTo(ProjectModel::class, 'project');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'file_user', 'file_id', 'user_id');
    }
}
