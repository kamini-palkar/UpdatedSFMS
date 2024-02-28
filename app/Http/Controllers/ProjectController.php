<?php

namespace App\Http\Controllers;

use App\Models\OrganisationMasterModel;
use App\Models\ProjectModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    //
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="SFMS MASTER";
    } 

    public function showProject(Request $request)
    {
 
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-project">PROJECT</a></li>';
       
        $title="SFMS - $orgcode->code - $module_name";
        return view('admin.Projects.showProject',compact(['breadcrumb','title']));
    }

    public function createProject(){
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-project">PROJECT</a></li>';
        $title="SFMS - $orgcode->code - $module_name";
    
        return view('admin.Projects.createProject',compact(['breadcrumb','title']));

    }

    public function showDataTable(Request $request){
        $orgid = auth()->user()->organisation_id;
    
        try {
            if ($request->ajax()) {
                // $Project = ProjectModel::select('*')
                // ->where('organisation_id', $orgid)
                // ->get();
                $Project = ProjectModel::select('projects.*', 'users.name as created_by')
                ->join('users', 'projects.created_by', '=', 'users.id')
                ->where('projects.organisation_id', $orgid)
                ->get();
                return DataTables::of($Project)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $encryptedId = encrypt($row->id);
                        $editUrl = route('edit-project', ['id' => $encryptedId]);
                        $deleteBtn = '';
                        $editBtn = '';
                        if (Gate::allows('delete-project')) {
                         
                            $deleteBtn = '<a  href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$encryptedId.'" data-original-title="Delete"   style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3 DeleteProject"><i class="fa fa-trash" style="color:red"></i></a>';
                        }
                        if (Gate::allows('edit-project')) {
              
                            $editBtn='<a href="' . $editUrl . '" title="Edit" class="menu-link flex-stack px-3" style="font-weight:normal !important;"><i class="fa fa-edit" id="ths" style="font-weight:normal !important;"></i></a>';
                        }
                    

                     $actionBtn =  $editBtn .$deleteBtn ;
                     return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    
                    ->make(true);
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

          
        return view('admin.Projects.showProjec');

    }
    
    public function storeProject(Request $request)
    {
     
        // dd($request);
        $request->validate([
            'name' => 'required',
            
        ]);
        $orgid = auth()->user()->organisation_id;
        $id = auth()->user()->id;
      
        try {
            DB::beginTransaction();
            $add = new ProjectModel;
            $add->name =$request->name;
            $add->organisation_id=$orgid ;
            $add->created_by= $id;
            $add->save();
            DB::commit();
           
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();

        }

        Session::flash('message', 'Organisation Added Successfully.!');
        return redirect('show-project');
                       
    }
    public function destroyProject($id)
    {
       DB::beginTransaction();
        try {
            $deleteProject = ProjectModel::find(decrypt($id));
            $deleteProject->delete();
           DB::commit();
        } 
        catch (Exception $exception) {
            DB::rollback();
            
            return back()->withError($exception->getMessage())->withInput();
        }
        Session::flash('message', 'Project deleted Successfully.!');
        return redirect('show-project');
                       

    }
    public function editProject($id)
    {


        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-project">PROJECT</a></li>';
        $Project = ProjectModel::find(decrypt($id));
        $title="SFMS - $orgcode->code - $module_name";
    
        return view('admin.Projects.editProject',compact(['breadcrumb','Project','title']));
    }

    public function updateProject(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
           
           
        ]);
        DB::beginTransaction();
        try {
            $project = ProjectModel::find(decrypt($id));
            $project->update($request->all());
            
            DB::commit();
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();

        }
        Session::flash('message', 'Project  update Successfully.!');
        return redirect('show-project');
        
    }

    public function updateProjectStatus($id)
    {
        
        $status = ProjectModel::where('id', $id)->value('status');
        if ($status==1)
        {
            ProjectModel::where('id', $id)->update(['status' => 0]);
            return response("updated");
        }
        elseif ($status==0){
            ProjectModel::where('id', $id)->update(['status' => 1]);
            return response("updated");
        }

    }


}
