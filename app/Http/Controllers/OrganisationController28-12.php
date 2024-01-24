<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Models\OrganisationMasterModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

use Exception;

class OrganisationController extends Controller
{
    public function showOrganisation(Request $request)
    {
       
        try {
            if ($request->ajax()) {
                $Organisation = OrganisationMasterModel::latest()->get();
                return DataTables::of($Organisation)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $encryptedId = encrypt($row->id);
                        $editUrl = route('edit-organisation', ['id' => $encryptedId]);
                        $deleteUrl = route('delete-organisation', ['id'=>$encryptedId]);
                    
                        $editBtn = '';
                        $deleteBtn = '';
    
                        // Check if the user has permission to edit
                        if (Gate::allows('edit-organisation')) {
                            $editBtn = '<a href="' . $editUrl . '" title="Edit" class="menu-link flex-stack px-3" style="font-weight:normal !important;"><i class="fa fa-edit" id="ths" style="font-weight:normal !important;"></i></a>';
                        }
    
                        // Check if the user has permission to delete
                        if (Gate::allows('delete-organisation')) {
                            $deleteBtn = '<a href="' . $deleteUrl . '" title="Delete" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-trash" style="color:red"></i></a>';
                        }
    
                       
                        $actionBtn = $editBtn . $deleteBtn;
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
        FacadesDB::beginTransaction();
        try {
            OrganisationMasterModel::create($request->all());
             FacadesDB::commit();
           
             $orgCode=$request->code;
            $publicPath = public_path("Organisation/{$orgCode}");
            if (!File::isDirectory($publicPath)) {
                File::makeDirectory($publicPath, 0755, true);
            }
        } catch (Exception $exception) {

            FacadesDB::rollback();
            return back()->withError($exception->getMessage())->withInput();

        }

        Session::flash('message', 'Organisation Added Successfully.!');
        return redirect('show-organisation');
                       
    }
   
    
    public function editOrganisation($id)
    {

        $Organisation = OrganisationMasterModel::find(decrypt($id));
        return view('admin.Organisation.editOrganisation' , ['Organisation'=>$Organisation]);
       
    }

    public function updateOrganisation(Request $request,$id)
    {
        // dd($id);
        $request->validate([
            'name' => 'required',
            'email'=>'required',
           
        ]);
        FacadesDB::beginTransaction();
        try {
            $org = OrganisationMasterModel::find(decrypt($id));
            $org->update($request->all());
            
            FacadesDB::commit();
        } catch (Exception $exception) {

            FacadesDB::rollback();
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
        FacadesDB::beginTransaction();
        try {
            $deleteOrg = OrganisationMasterModel::find(decrypt($id));
            $deleteOrg->delete();
            FacadesDB::commit();
        } 
        catch (Exception $exception) {
            FacadesDB::rollback();
            
            return back()->withError($exception->getMessage())->withInput();
        }
        Session::flash('message', 'Organisation deleted Successfully.!');
        return redirect('show-organisation');
                       

    }

}
