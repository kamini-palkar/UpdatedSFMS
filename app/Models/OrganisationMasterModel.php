<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrganisationMasterModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "organisation_master";
    protected $guarded =[];
}
