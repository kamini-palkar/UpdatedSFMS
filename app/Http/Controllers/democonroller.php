<?php

namespace App\Http\Controllers;

use App\Models\FileUploadModel;
use App\Models\FileLogModel;
use App\Models\OrganisationMasterModel;
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

                $fileSize = $file->getSize();


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
                
                $add->save();
            }
            
            $names = FileUploadModel::select('unique_id', 'id', 'name' , 'size' , 'added_by' , 'created_at')->where('record_unique_id', $RecordUniqueId)->get();
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


    public function showFile(Request $request)
    {
        $org_code = auth()->user()->organisation_code;
        $user_id = auth()->id();
        $Created_by_name = auth()->user()->name;
    
      
    
        try {
            if ($request->ajax()) {
                $showFile = FileUploadModel::select('*')
                    ->where('org_code', $org_code)
                    ->get();

                    $loggedInUserName = auth()->user()->name; 
                    return DataTables::of($showFile)
                    ->addIndexColumn()
                    ->addColumn('action',  function ($row) use ($loggedInUserName) {

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
                            $deleteBtn = '<a href="' . $deleteUrl . '" title="Delete" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-trash" style="color:red"></i></a>';
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
    
                        // Check if the user has permission to email
                        if (\Gate::allows('send-email')) {
                            $emailBtn = '<a href="' . $emailPopupUrl . '" title="Email" data-toggle="modal" data-target="#emailModal" data-file-id="' . $row->id . '" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-envelope" style="color:#dd6e42"></i></a>';
                        }

                          if($row->added_by==$loggedInUserName){
                              $uploadBtn = '<a href="javascript:void(0)" title="Uploaded" style="cursor: pointer;font-weight:normal !important;" class="menu-link flex-stack px-3"><i class="fa fa-upload" style="color:#0077b6"></i></a>';
                          }

                          $infoBtn =' <a href="javascript:void(0)" data-toggle="modal" data-id="'.$row->id.'" data-target="#detailModal" title="View Receiver List" class="viewReceiver menu-link flex-stack px-3"> <i class="fa fa-info-circle" style="color:blue"> </i></a> ';

                       
                       
           
                       
                        // Concatenate the buttons
                        $actionBtn = $deleteBtn . $downloadBtn . $viewBtn . $emailBtn .  $uploadBtn . $infoBtn ;
    
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    
        return view('admin.Files.showFile' , ['Created_by_name' , $Created_by_name]);
    }
    
    public function destroyFile($id)
    {

        DB::beginTransaction();
        try {
            $user_id = auth()->id();
            $destroyFile = FileUploadModel::find(decrypt($id));
            $destroyFile::where('id', $destroyFile->id)->update(['deleted_by' => $user_id]);
            $destroyFile->delete();
            DB::commit();
        } catch (Exception $exception) {

            DB::rollback();
            return back()->withError($exception->getMessage())->withInput();
        }
        Session::flash('message', 'File Deleted Successfully.!');
        return redirect('show-files');
    }

    public function downloadFile($id)
    {
        $file = FileUploadModel::findOrFail(decrypt($id));
    
        $orgCode = auth()->user()->organisation_code;
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $publicPath = public_path("Organisation/{$orgCode}/{$currentYear}/{$currentMonth}");
    
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
        } else {
           
            return response()->json(['error' => 'File not found'], 404);
        }
    }
    
    public function viewFile($id)
    {
        $file = FileUploadModel::findOrFail(decrypt($id));
    
        $orgCode = auth()->user()->organisation_code;
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $publicPath = public_path("Organisation/{$orgCode}/{$currentYear}/{$currentMonth}");
    
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
        $file = FileUploadModel::find($fileId);
        $names = FileUploadModel::select('unique_id', 'id', 'name', 'size', 'added_by', 'created_at','email')
            ->where('id', $fileId)
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

        //    adding this email in table
        $newEmails = explode(',', $email);
        $oldEmails = explode(',', $file->email);
        // Combine and make unique
        $combinedEmails = implode(',', array_unique(array_merge($newEmails, $oldEmails)));
           FileUploadModel::where('id', $fileId)
           ->update(['email' => $combinedEmails]);    
        return response()->json(['message' => 'Nishant.Email sent successfully']);
    }
    

}
