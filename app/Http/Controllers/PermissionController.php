<?php

namespace App\Http\Controllers;

use App\Models\OrganisationMasterModel;
use App\Models\PermissionModel;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public $permission_model;
    public function __construct()
    {
        $this->permission_model = new PermissionModel();
        $this->middleware('auth');
        $this->module_name="ACL";
    }
     
    public function createPermission()
    {
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . ' </li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/showPermission">PERMISSIONS';
        $title="SFMS-$orgcode->code -$module_name";
        return view('admin.permission.addPermission',compact(['breadcrumb','title']));
    }

    public function storePermission(Request $request, PermissionModel $pm)
    {

        $store = new PermissionModel;
        $store->name = $request->get('name');
        $store->guard_name = $request->get('guard_name');
        $store->created_by = auth()->id();
        $store->save();
        Session::flash('message', 'Permission added successfully.');
        return redirect('showPermission');
    }


    // fetch all permissions 
    public function fetchPermission(Request $request)
    {
        $permission_data = $this->permission_model->fetchPermission();
        $role_data = Role::findById($request->role_id);
        $rolepermission = $role_data->permissions->pluck('id')->toArray();
        $html = view('admin.RolesAndPermission.partialFiles.partial', ['permission_data' => $permission_data, 'rolepermission' => $rolepermission])->render();

        $response['html'] = $html;
        $response['status'] = true;
        return response(json_encode($response), 200);
    }
    public function showPermission(Request $request)
    {
        try {
            if ($request->ajax()) {
                $Organisation = $this->permission_model->fetchPermission();
                return DataTables::of($Organisation)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $encryptedId = encrypt($row->id);
                        $editUrl = route('edit-permission', ['id' => $encryptedId]);
                        $deleteUrl = route('delete-permission', ['id' => $encryptedId]);

                        $actionBtn = '<a href="' . $editUrl . '" title="Edit" class="menu-link flex-stack px-3" style="font-weight:normal !important;"><i class="fa fa-edit" id="ths" style="font-weight:normal !important;"></i></a>
                     <a  href="' . $deleteUrl . ' "title="Delete"   style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-trash" style="color:red"></i></a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])

                    ->make(true);
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.'</li> <li class="breadcrumb-item active"><a href="/showPermission">PERMISSIONS';
        $title="SFMS-$orgcode->code -$module_name"; 
        return view('admin.permission.showPermission',compact(['breadcrumb','title']));
       
    }

    public function editPermission($id, PermissionModel $pm)
    {
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.'</li> <li class="breadcrumb-item active"><a href="/showPermission">PERMISSIONS';
        $title="SFMS-$orgcode->code -$module_name";
        $edit = PermissionModel::find(decrypt($id));
        return view('admin.permission.updatePermission', ['edit' => $edit,'breadcrumb'=>$breadcrumb,'title'=>$title]);
    }

    public function updatePermission(Request $request, $id, PermissionModel $pm)
    {

        $up = PermissionModel::find(decrypt($id));
        $up->name = $request->get('name');
        $up->updated_by = auth()->id();
        $up->save();
        Session::flash('message', 'Permission updated successfully.');
        return redirect('showPermission');
    }

    public function destroyPermission($id, PermissionModel $pm)
{
    try {
        $user_id = auth()->id();
        $delete = PermissionModel::find(decrypt($id));

        if ($delete) {
           
            $delete->deleted_by = $user_id;
            $delete->save();
            $delete->delete();

            Session::flash('message', 'Permission Deleted successfully!');
        } else {
            Session::flash('error', 'Permission not found!');
        }
    } catch (Exception $exception) {
        Session::flash('error', $exception->getMessage());
    }

    return redirect('showPermission');
}


}