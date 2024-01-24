<?php

namespace App\Http\Controllers;

use App\Models\FileLogModel;
use App\Models\FileUploadModel;
use App\Models\OrganisationMasterModel;
use App\Models\ProjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
class FileUploadController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="FILE UPLOAD";
    }  

    private function generateUniqueId($organisationCode)
    {
        $lastRecord = FileUploadModel::where('org_code', $organisationCode)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord) {
            $lastUniqueId = intval(preg_replace('/[^0-9]/', '', $lastRecord->unique_id));
            $newUniqueId = $organisationCode . '_' . ($lastUniqueId + 1);
        } else {
            $newUniqueId = $organisationCode . '_1';
        }

        return $newUniqueId;
    }

    public function storeFiles(Request $request)
    {
    //    dd($request);
        $RecordUniqueId = time() . '_' . mt_rand();
        $files = $request->file('name', []);
        $email = $request->input('email');

        $fileCount = count($files);

        if ($fileCount > 0) {

            foreach ($files as $file) {
                $add = new FileUploadModel;
                $add->name = $file->getClientOriginalName();
                $add->email = $email;
                $add->org_code = auth()->user()->organisation_code;
                $uniqueId = $this->generateUniqueId($add->org_code);
                $currentYear = now()->year;
                $currentMonth = now()->month;

                $publicPath = public_path("Organisation/{$add->org_code}/{$currentYear}/{$currentMonth}");

                if (!File::isDirectory($publicPath)) {
                    File::makeDirectory($publicPath, 0755, true);
                }
                 //size in bytes
                $fileSize = $file->getSize();
                $add->size_in_bytes= $fileSize ;

              
                if ($fileSize >= 1048576) { 
                    $fileSizeFormatted = number_format($fileSize / 1048576, 2) . ' MB';
                } else {
                    $fileSizeFormatted = number_format($fileSize / 1024, 2) . ' KB';
                }
                $add->size = $fileSizeFormatted;
                
                $file->move($publicPath, $file->getClientOriginalName());
                $add->unique_id = $uniqueId;
                $add->record_unique_id = $RecordUniqueId;
                $add->created_by = auth()->id();
                $add->updated_by = auth()->id();
                $add->added_by = auth()->user()->name;

                $project = $request->input('project');
                $purpose = $request->input('purpose');
                $add->project=$project;
                $add->purpose=$purpose;
                $organisation = OrganisationMasterModel::select('id')
                    ->where('code', $add->org_code)
                    ->first();

                if ($organisation) {
                    $add->organisation_id = $organisation->id;
                }
                
                $add->save();
            }
            
            // $names = FileUploadModel::select('unique_id', 'id', 'name' , 'size' , 'added_by' , 'created_at','project')->where('record_unique_id', $RecordUniqueId)->get();
            $names = FileUploadModel::select('files.unique_id', 'files.id', 'files.name', 'files.size', 'files.added_by', 
            'files.created_at', 'files.project','files.purpose', 'projects.name as project')
             ->join('projects', 'files.project', '=', 'projects.id')
              ->where('files.record_unique_id', $RecordUniqueId)
             ->get();

            $url = "http://files.seqr.info/home";

            $regardsName = auth()->user()->name;
            $id_for_mail = auth()->user()->organisation_id;

            $organisation_name = DB::table('organisation_master')->where('id', $id_for_mail)->get();
            $nameForMail = $organisation_name[0]->name;

            $email = $request->input('email');

            $emails = explode(',', $email);
            $validatedEmails = array_map('trim', $emails);
            $validatedEmails = array_filter($validatedEmails, 'filter_var', FILTER_VALIDATE_EMAIL);

            $data["title"] = "$nameForMail Sent You Files";
            $data["body"] = " You have received $fileCount Files . Please log in to the  $url to view sent files.";
            $data["regardsName"] = $regardsName;
            $data["filesForMail"] = $files;
            $data["names"] = $names;

            Mail::send('demoMail', $data, function ($message) use ($data, $validatedEmails, $regardsName) {
                $message->to($validatedEmails, $validatedEmails)
                    ->subject($data["title"]);

            });
        } 
        return response()->json(['message' => 'Files uploaded successfully']);
    }
    public function create(){
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-files">FILES</a></li>';
        $title="SFMS - $orgcode->code - $module_name";
        $project=  ProjectModel::where('organisation_id', $orgid) ->where('status', 1)->get();
    
        return view('admin.Files.uploadFile',compact(['breadcrumb','title','project']));

    }


    public function showFile(Request $request)
    {

        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        // dd($orgcode->code );
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-files">FILES</a></li>';
        $title="SFMS - $orgcode->code - $module_name";

        $project=  ProjectModel::where('organisation_id', $orgid)->get();
        $uploadedBy = DB::table('files')
        ->select('added_by')
        ->distinct()
        ->where('organisation_id', $orgid)
        ->pluck('added_by');
    
        // dd($uploadedBy);
        return view('admin.Files.showFile',compact(['breadcrumb','title','project','uploadedBy']));
    }



    public function showDataTable(Request $request)
    {
        $org_code = auth()->user()->organisation_code;
        $user_id = auth()->id();
        $Created_by_name = auth()->user()->name;
       
    
        try {
            if ($request->ajax()) {
              
                $searchbtnClick = $request->searchbtnClick;
                $project=$request->project;
                $addedBy=$request->addedeBy;
                $documentType=$request->documentType;
                $var_doc_date_from = $request->doc_date_from;
                $var_doc_date_to = $request->doc_date_to;
                
                if ($var_doc_date_from) {
                    $date_from = str_replace('/', '-', $var_doc_date_from);
                    $doc_date_from = date('Y-m-d', strtotime($date_from));
                } else {
                    $doc_date_from = '';
                }
              
                if ($var_doc_date_to) {
                    $date_to = str_replace('/', '-', $var_doc_date_to);
                    $doc_date_to = date('Y-m-d', strtotime($date_to));
                } else {
                    $doc_date_to = '';
                }
                if ($doc_date_from != '' && $doc_date_to != '') {
                    $doc_date_range = array($doc_date_from, $doc_date_to);
                } else {
                    $doc_date_range = "";
                }


                $query = FileUploadModel::select('files.*', 'projects.name as project')
                ->leftjoin('projects', 'files.project', '=', 'projects.id')
                ->when($addedBy, function ($query, $addedBy) {
                    return $query->where('added_by', $addedBy);
                })
                ->when($project, function ($query, $project) {
                    return $query->where('projects.name', $project);
                })
                ->when($documentType, function ($query, $documentType) {
                    return $query->where('files.name', 'LIKE', "%$documentType%");
                })
                ->when($doc_date_range, function ($query, $doc_date_range) {
                    return $query->whereBetween(DB::raw('DATE(files.created_at)'), [$doc_date_range[0], $doc_date_range[1]]);
                })
                ->where('org_code', $org_code);
            
       
            
                    $loggedInUserName = auth()->user()->name; 
                    return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row)use ($loggedInUserName) {
    
                        $deleteUrl = route('delete-file', ['id' => encrypt($row->id)]);
                        $downloadUrl = route('download.file', ['id' => encrypt($row->id)]);
                        $emailPopupUrl = route('show-files');
                        $viewUrl = route('view.file', ['id' => encrypt($row->id)]);
    
                        $deleteBtn = '';
                        $downloadBtn = '';
                        $emailBtn = '';
                        $uploadBtn='';
                        $viewBtn='';
                        $infoBtn='';
    
                        // Check if the user has permission to delete
                        if (\Gate::allows('delete-files')) {
                            $deleteBtn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete"  style="cursor: pointer;font-weight:normal !important;" class=" DeleteFile menu-link flex-stack px-3"><i class="fa fa-trash" style="color:red"></i></a>';
                           
                        }
                        
                        // Check if the user has permission to email
                        if (\Gate::allows('send-email')) {
                            $emailBtn = '<a href="' . $emailPopupUrl . '" title="Email" data-toggle="modal" data-target="#emailModal" data-file-id="' . $row->id . '" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-envelope" style="color:#dd6e42"></i></a>';
                        }
    
                        // Check if the user has permission to download
                        if (\Gate::allows('download-file')) {
                            $downloadBtn = '<a href="' . $downloadUrl . '" title="Download" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-download" style="color:#0077b6"></i></a>';

                            $fileName = $row->name;
                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                            
                            if ( strtolower($fileExtension) == 'pdf' || strtolower($fileExtension) == 'jpg'||strtolower($fileExtension) == 'png') {
                                $viewBtn = '<a href="' . $viewUrl . '" title="View" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3" target="_blank"><i class="fa fa-eye" style="color:#0077b6"></i></a>';
                            }
                        }
    


                        $infoBtn =' <a href="javascript:void(0)" data-toggle="modal" data-id="'.$row->id.'" data-target="#detailModal" title="View Receiver List" class="viewReceiver menu-link flex-stack px-3"> <i class="fa fa-info-circle" style="color:blue"> </i></a> ';

                        if($row->added_by==$loggedInUserName){
                            $uploadBtn = '<a href="javascript:void(0)" title="Uploaded" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-upload" style="color:#0077b6"></i></a>';
                        }
    
                        // Concatenate the buttons
                        $actionBtn = $deleteBtn . $emailBtn .  $infoBtn .$downloadBtn . $viewBtn  . $uploadBtn ;
    
    
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            else{
                dd("qq");
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
       
    }
    
    public function destroyFile($id)
    {
    //   dd($id);
        DB::beginTransaction();
        try {
            $user_id = auth()->id();
            $destroyFile = FileUploadModel::find($id);
            $destroyFile::where('id', $destroyFile->id)->update(['deleted_by' => $user_id]);
            $destroyFile->delete();
            DB::commit();
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
     
        session()->flash('success', 'File deleted successfully');

        return response()->json(['success' => true, 'message' => 'File deleted successfully']);
    }

    public function downloadFile($id)
    {
        $file = FileUploadModel::findOrFail(decrypt($id));
        $date = $file->created_at;
        $year = $date->format('Y');
        $month = $date->format('n');

        // dd($year, $month);
        $orgCode = auth()->user()->organisation_code;
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $publicPath = public_path("Organisation/{$orgCode}/{$year}/{$month}");
    
        $filePath = $publicPath . '/' . $file->name;

       //insert log
       $user_id = auth()->id();
       $file_id=decrypt($id);
       $add = new FileLogModel;
       $add->file_id=  $file_id;
       $add->user_id= $user_id;      
       $add->save();
        
             
        if (file_exists($filePath)) {

             //insert user id if download 
             $user = FileUploadModel::find(decrypt($id));
             if ($user) {
                 $oldUser = $user->downloaded ? explode(',', $user->downloaded) : [];
                 $newUser = $user_id;            
                 $combinedUser = implode(',', array_unique(array_merge($oldUser, [$newUser])));
                 FileUploadModel::where('id', (decrypt($id)))
                     ->update(['downloaded' => $combinedUser]);
             } 

            return response()->download($filePath, $file->name);
           } 
            else {
           
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    public function viewFile($id)
    {
        $file = FileUploadModel::findOrFail(decrypt($id));
    
        $orgCode = auth()->user()->organisation_code;
        $date = $file->created_at;
        $year = $date->format('Y');
        $month = $date->format('n');
        $publicPath = public_path("Organisation/$orgCode/$year/$month");
        $filePath = $publicPath . '/' . $file->name;
        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
           
            return response()->json(['error' => 'File not found'], 404);
        }
    }

     public function viewReceiver($id){
 
        $email = FileUploadModel::select('email')
        ->where('id', $id)
        ->get();
      
        if (!$email) {
            return response()->json(['error' => 'Record not found'], 404);
        }
    
        return response()->json($email);
     }


    public function sendEmail(Request $request){
        
        $email = $request->input('email');
        $fileId = $request->input('fileId');
    

        $names = FileUploadModel::select('files.unique_id', 'files.id', 'files.name', 'files.size', 'files.added_by', 
        'files.created_at', 'files.project','files.purpose', 'projects.name as project')
         ->join('projects', 'files.project', '=', 'projects.id')
            ->where('files.id', $fileId)
            ->get();

          
        $url = "http://files.seqr.info/home";
        $regardsName = auth()->user()->name;
        $id_for_mail = auth()->user()->organisation_id;
        $organisation_name = DB::table('organisation_master')->where('id', $id_for_mail)->get();
        $nameForMail = $organisation_name[0]->name;
    
        $emails = explode(',', $email);
        $validatedEmails = array_map('trim', $emails);
        $validatedEmails = array_filter($validatedEmails, 'filter_var', FILTER_VALIDATE_EMAIL);
    
     
        $data["title"] = "$nameForMail Sent You Files";
        $data["body"] = "You have received " . count($names) . " files. Please log in to $url to view sent files.";
        $data["regardsName"] = $regardsName;
        $data["names"] = $names;
    
      
        Mail::send('demoMail', $data, function ($message) use ($data, $validatedEmails, $regardsName) {
            $message->to($validatedEmails, $validatedEmails)
                ->subject($data["title"]);
        });
    
        return response()->json(['message' => 'Nishant.Email sent successfully']);
    }
    

}
