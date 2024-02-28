<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\OrganisationMasterModel;
use App\Models\PermissionModel;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Support\Facades\DB;
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
        $Menus = Menu::where('parent_id', 0)->get();
        $title="SFMS-$orgcode->code -$module_name";
        return view('admin.permission.addPermission',compact(['breadcrumb','title','Menus']));
    }


    public function getSubmenus($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu) {
            return response()->json(['error' => 'Menu not found'], 404);
        }
        $submenus = $menu->submenus;
        return response()->json($submenus);
    }


    // get submenus childs

    public function getChildMenus($submenuId)
    {
      
        $childMenus = Menu::where('parent_id', $submenuId)->get();

        return response()->json($childMenus);
    }

    public function storePermission(Request $request, PermissionModel $pm)
    {
        // dd($request);
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'guard_name' => 'required',
            'menu_id' => 'required',
            'sub_menu_id' => 'nullable',
            'child_menu_id'=>'nullable'
        ]);
        $store = new PermissionModel;
        if($request->get('submenu_id')==''){
            $store->sub_menu_id = $request->get('menu_id');
        }
        else{
            $store->sub_menu_id = $request->get('submenu_id');
        }
    
        $store->title = $request->get('title');
        $store->name = $request->get('name');
        $store->guard_name = $request->get('guard_name');
        $store->created_by = auth()->id();
        $store->menu_id = $request->get('menu_id');
       
       
        $store->save();
        Session::flash('message', 'Permission added successfully.');
        return redirect('showPermission');
    }


    // fetch all permissions 
    public function fetchPermission(Request $request)
    {


        // $permission_data = $this->permission_model->fetchPermission();
        // $role_data = Role::findById($request->role_id);
        // $rolepermission = $role_data->permissions->pluck('id')->toArray();
       
        // // send menus in partial file
       
        // $Menus = Menu::with('submenus.permissions')->where('parent_id', 0)->get();

        $data = Role::find($request->role_id);   
     
        $permission = PermissionModel::orderBy('menu_id')->orderBy('sub_menu_id')->get();
        
        $roles_permissions = $data->permissions->pluck('id')->toArray();
     
        $menus = Menu::get()->pluck('title','id')->toArray();
        //$menus = Menu::get(['title','id', 'parent_id'])->toArray();
        // $menuData = DB::table('menus')->select('title', 'id', 'parent_id')->get();
        // $menus = json_decode(json_encode($menuData), true);
       
    //   dd($menus); 
        $html = view('admin.RolesAndPermission.partialFiles.partial', compact(['data','permission','roles_permissions','menus']))->render();
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
        $title="SFMS - $orgcode->code - $module_name"; 
        return view('admin.permission.showPermission',compact(['breadcrumb','title']));
       
    }

    public function editPermission($id, PermissionModel $pm)
    {
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' .$orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.'</li> <li class="breadcrumb-item active"><a href="/showPermission">PERMISSIONS';
        $title="SFMS  - $orgcode->code - $module_name";
        $edit = PermissionModel::find(decrypt($id));
        $Menus = Menu::where('parent_id', 0)->get();
        return view('admin.permission.updatePermission', ['edit' => $edit,'breadcrumb'=>$breadcrumb,'title'=>$title,'Menus'=>$Menus]);
    }

    public function updatePermission(Request $request, $id, PermissionModel $pm)
    {

        // $up = PermissionModel::find(decrypt($id));
        // $up->name = $request->get('name');
        // $up->updated_by = auth()->id();
        // $up->save();
        // Session::flash('message', 'Permission updated successfully.');
        // return redirect('showPermission');
        $request->validate([
            'title' => 'required',
            'name' => 'required',
            'guard_name' => 'required',
            'menu_id' => 'required',
            'submenu_id' => 'nullable',
          
        ]);
        DB::beginTransaction();
 
            
            $up = PermissionModel::find(decrypt($id));
            if($request->get('submenu_id')==''){
                $up->sub_menu_id = $request->get('menu_id');
            }
            else{
                $up->sub_menu_id = $request->get('submenu_id');
            }
            $up->title = $request->get('title');
            $up->name = $request->get('name');
            $up->menu_id = $request->get('menu_id');
            $up->sub_menu_id = $request->get('submenu_id');
            // $up->child_menu_id = $request->get('child_menu_id');
            $up->updated_by = auth()->id();
           
            $up->save();
            // dd(2);
      
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