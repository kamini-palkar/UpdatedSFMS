<?php

namespace App\Http\Controllers;

use App\Models\OrganisationMasterModel;
use App\Models\RolesAndPermissionModel;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="ACL";
    } 

    public function storeRolesAndPermission(Request $request)
    {
        $roleId = $request->role;
        $permissionIds = $request->permission;
    
        // Clear cached permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    
        // Get the role
        $role = Role::findOrFail($roleId);
    
        // Detach existing permissions for the role
        $role->permissions()->detach();
    
        // Attach new permissions to the role
        foreach ($permissionIds as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $role->givePermissionTo($permission);
        }
    
        return redirect('/showroles_and_permission')->with('message', 'Permissions assigned successfully.');
    }

    public function showRP(Request $request)
    {
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.'</li> <li class="breadcrumb-item active"><a href="/showroles_and_permission">ROLES HAS PERMISSION';
        $title="SFMS - $orgcode->code - $module_name";

        $Ads = RolesAndPermissionModel::where('deleted_at', null)->get();
        return view('admin.RolesAndPermission.showroles_and_permission', ['Ads' => $Ads ,'title'=>$title,'breadcrumb'=>$breadcrumb]);
    }
}