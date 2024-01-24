<?php

namespace App\Http\Controllers;
use App\Models\FileUploadModel;
use App\Models\OrganisationMasterModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

use Exception;
use Illuminate\Support\Facades\Mail;

class OrganisationController extends Controller
{

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="SFMS MASTER";
    } 
    public function showOrganisation(Request $request)
    {
       


        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-organisation">ORGANISATION</a></li>';
       
        $title="SFMS-$orgcode->code -$module_name";
        return view('datepicker');
        // return view('admin.Organisation.showOrganisation',compact(['breadcrumb','title']));
    }
    
    public function createOrganisation(){
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-organisation">ORGANISATION</a></li>';
        $title="SFMS-$orgcode->code -$module_name";
    
        return view('admin.Organisation.createOrganisation',compact(['breadcrumb','title']));

    }

    public function showDataTable(Request $request){
        try {
            if ($request->ajax()) {
                $Organisation = OrganisationMasterModel::latest()->get();
                return DataTables::of($Organisation)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $encryptedId = encrypt($row->id);
                        $editUrl = route('edit-organisation', ['id' => $encryptedId]);
                        $deleteUrl = route('delete-organisation', ['id'=>$encryptedId]);
                        $deleteBtn = '';
                        $editBtn = '';
                        $deleteBtn = '<a  href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$encryptedId.'" data-original-title="Delete"   style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3 DeleteOrganisation"><i class="fa fa-trash" style="color:red"></i></a>';

                        $editBtn='<a href="' . $editUrl . '" title="Edit" class="menu-link flex-stack px-3" style="font-weight:normal !important;"><i class="fa fa-edit" id="ths" style="font-weight:normal !important;"></i></a>';
                       
                    

                     $actionBtn =  $editBtn .$deleteBtn ;
                     return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    
                    ->make(true);
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

          
        return view('admin.Organisation.showOrganisation');

    }
  
    public function storeOrganisation(Request $request)
    {
     
        $request->validate([
            'name' => 'required',
            'code' => 'required|unique:organisation_master',
            'email'=> 'required',
        ]);
        DB::beginTransaction();
        try {
            OrganisationMasterModel::create($request->all());
            DB::commit();
           
             $orgCode=$request->code;
            $publicPath = public_path("Organisation/{$orgCode}");
            if (!File::isDirectory($publicPath)) {
                File::makeDirectory($publicPath, 0755, true);
            }
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();

        }

        Session::flash('message', 'Organisation Added Successfully.!');
        return redirect('show-organisation');
                       
    }
   
    
    public function editOrganisation($id)
    {


        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-organisation">ORGANISATION</a></li>';
        $Organisation = OrganisationMasterModel::find(decrypt($id));
        $title="SFMS-$orgcode->code -$module_name";
    
        return view('admin.Organisation.editOrganisation',compact(['breadcrumb','Organisation','title']));
    }

    public function updateOrganisation(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'email'=>'required',
           
        ]);
        DB::beginTransaction();
        try {
            $org = OrganisationMasterModel::find(decrypt($id));
            $org->update($request->all());
            
            DB::commit();
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();

        }
        Session::flash('message', 'Organisation update Successfully.!');
        return redirect('show-organisation');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyOrganisation($id)
    {
       DB::beginTransaction();
        try {
            $deleteOrg = OrganisationMasterModel::find(decrypt($id));
            $deleteOrg->delete();
           DB::commit();
        } 
        catch (Exception $exception) {
            DB::rollback();
            
            return back()->withError($exception->getMessage())->withInput();
        }
        Session::flash('message', 'Organisation deleted Successfully.!');
        return redirect('show-organisation');
                       

    }

}
