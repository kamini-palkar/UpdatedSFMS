<?php

namespace App\Http\Controllers;

use App\Models\OrganisationMasterModel;
use App\Models\RolesModel;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;
class RolesController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="ACL";
    } 
    public function createRole()
    {
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . ' </li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/showRoles">ROLES';
        $title="SFMS-$orgcode->code -$module_name"; 
        return view('admin.roles.addRoles',compact(['breadcrumb','title']));

    }

    public function storeRole(Request $request, RolesModel $rm)
    {
      

        $addRole = new RolesModel;
        $addRole->name = $request->get('name');
        $addRole->guard_name = $request->get('guard_name');
        $addRole->created_by = auth()->id();
        $addRole->save();
        Session::flash('message', 'Role added successfully.!');
        return redirect('showRoles');
    }




    public function showRole(Request $request)
    {
        try {
            if ($request->ajax()) {
                $Organisation = RolesModel::latest()->get();
                return DataTables::of($Organisation)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $encryptedId = encrypt($row->id);
                        $editUrl = route('edit-role', ['id' => $encryptedId]);
                        $deleteUrl = route('delete-role', ['id'=>$encryptedId]);
                       
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
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.'</li> <li class="breadcrumb-item active"><a href="/showRoles">ROLES';
        $title="SFMS-$orgcode->code -$module_name";
        return view('admin.roles.showRoles',compact(['breadcrumb','title']));
    }



    public function editRole($id, RolesModel $rm)
    {

        $edit = RolesModel::find(decrypt($id));
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/showRoles">ROLES';
        $title="SFMS-$orgcode->code -$module_name";
        
        return view('admin.roles.updateRoles', ['edit' => $edit ,'breadcrumb'=>$breadcrumb,'title'=>$title]);
    }


    public function updateRole(Request $request, $id, RolesModel $rm)
    {

        $update = RolesModel::find(decrypt($id));
        $update->name = $request->get('name');
        $update->updated_by = auth()->id();
        $update->save();
        Session::flash('message', 'Role Updated successfully.!');
        return redirect('showRoles');
    }


    public function destroyRole($id, RolesModel $rm)
    {
        try {
            $user_id = auth()->id();
            $delete = RolesModel::find(decrypt($id));
    
            if ($delete) {
               
                $delete->update(['deleted_by' => $user_id]);
    
              
                $delete->delete();
    
                Session::flash('message', 'Role Deleted successfully!');
            } else {
                Session::flash('error', 'Role not found!');
            }
        } catch (Exception $exception) {
            Session::flash('error', $exception->getMessage());
        }
    
        return redirect('showRoles');
    }
    
}
