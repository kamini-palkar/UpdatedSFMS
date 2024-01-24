<?php

namespace App\Http\Controllers;

use App\Models\FileUploadModel;
use App\Models\ModelHasRoles;
use App\Models\RolesAndPermissionModel;
use App\Models\RolesModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use App\Models\OrganisationMasterModel;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function getOrganisationDetails()
    {
        $data = OrganisationMasterModel::all();
        // sending roles whose deleted at = null
        $roles = RolesAndPermissionModel::where('deleted_at', null)->get();
        return view('admin.User.createUser', ['data' => $data , 'roles'=>$roles]);
    }
    public function getOrganisationCode($id)
    {
        $organisation = OrganisationMasterModel::find($id);

        if ($organisation) {
            return response()->json(['organisation_code' => $organisation->code]);
        } else {
            return response()->json(['organisation_code' => null]);
        }
    }
    public function storeUser(Request $request)
    {
       
        $validated = $request->validate([
            'organisation_id' => 'required',
            'name' => 'required',
            'username' => [
                'required',
                'string',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('organisation_id', $request->get('organisation_id'));
                }),
            ],
            'password' => 'required',
           
        ]);
        
            $storeUser = new User();
            $storeUser->organisation_id = $request->get('organisation_id');
            $storeUser->organisation_code = $request->get('organisation_code');
            $storeUser->name = $request->get('name');
            $storeUser->username = $request->get('username');
            $storeUser->password = $request->get('password');
            $storeUser->role_id = $request->input('role_id');
            $storeUser->created_by = auth()->id();
            $storeUser->updated_by = auth()->id();
            $storeUser->created_at = now();
            $storeUser->updated_at = now();
            $storeUser->save();

            $storeUserHasRole = $request->input('role_id');
            $user_id = $storeUser->id;
            $model_type="App\Models\User";
            
            $addInmodelHasRoles = new ModelHasRoles();
            $addInmodelHasRoles->role_id = $storeUserHasRole;
            $addInmodelHasRoles->model_type = $model_type;
            $addInmodelHasRoles->model_id = $user_id;
            
            $addInmodelHasRoles->save(); 
         
        Session::flash('message', 'User Added Successfully.!');
        return redirect('show-user');
    }
    public function showUser(Request $request)
    {
    
        try {
            if ($request->ajax()) {
            

                $showGst = User::select('users.*', 'roles.name as role_name')
                    ->leftJoin('roles', 'users.role_id', '=', 'roles.id')->get();

            
            
                return DataTables::of($showGst)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $encryptedId = encrypt($row->id);
                        $editUrl = route('edit-user', ['id' => $encryptedId]);
                        $deleteUrl = route('delete-user', ['id' => $row->id]);

                        $editBtn = '';
                        $deleteBtn = '';

                        // Check if the user has permission to edit
                        if (Gate::allows('edit-user')) {
                            $editBtn = '<a href="' . $editUrl . '" title="Edit" class="menu-link flex-stack px-3" style="font-weight:normal !important;"><i class="fa fa-edit" id="ths" style="font-weight:normal !important;"></i></a>';
                        }

                        // Check if the user has permission to delete
                        if (Gate::allows('delete-user')) {
                            $deleteBtn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$encryptedId.'" data-original-title="Delete" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3 Deleteuser"><i class="fa fa-trash" style="color:red"></i></a>';
                        }

                        // Concatenate the buttons
                        $actionBtn = $editBtn . $deleteBtn;

                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return view('admin.User.showUser');
    }

    public function editUser($id)
    {
        try {
            $editUser = User::find(decrypt($id));
            $data = OrganisationMasterModel::all();

            $roles = RolesAndPermissionModel::where('deleted_at', null)->get();

        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('admin.User.editUser', ['editUser' => $editUser, 'data' => $data , 'roles'=>$roles]);
    }


    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $updateUser = User::find(decrypt($id));
            $updateUser->name = $request->get('name');
            $updateUser->password = $request->get('password');
            $updateUser->updated_by = auth()->id();
            $updateUser->updated_at = now();
            $updateUser->role_id = $request->input('role_id');
            $updateUser->save();

            ModelHasRoles::where('model_id',  $updateUser->id)
          
            ->update(['role_id' =>  $updateUser->role_id ]);

            DB::commit();
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        Session::flash('message', 'User Updated Successfully.!');
        return redirect('show-user');

    }

    public function destroyUser($id)
    {
        DB::beginTransaction();
        try { 
            // dd($id);

            $checkFile = FileUploadModel::where('created_by',decrypt($id))->get();
            // dd($checkFile);
            if ($checkFile->isEmpty()) {
                $deleteUser = User::find(decrypt($id));
                $deleteUser->delete();
                DB::commit();
                // echo "1";
                return response("deleted");
                // return response(" deleted")->json(['message'=>'User deleted successfully.']);
               
            }
            else{
                return response("not deleted");
                // return response()->json(['message'=>'User can not be successfully.']);

            }
           
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        Session::flash('message', 'User Deleted Successfully.!');
        return redirect('show-user');
    }
    public function updateUserStatus($id){
        // dd($id);
        // $updateUser = User::where('id', $id)->get('status');
        $status = User::where('id', $id)->value('status');
        if ($status==1)
        {
            User::where('id', $id)->update(['status' => 0]);
            return response("updated");
        }
        elseif ($status==0){
            User::where('id', $id)->update(['status' => 1]);
            return response("updated");
        }

    }
}
