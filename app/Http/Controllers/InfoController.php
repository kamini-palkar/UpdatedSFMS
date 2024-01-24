<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUploadModel;
use App\Models\OrganisationMasterModel;
use App\Models\User;
use Carbon\Carbon;

class InfoController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->module_name="DASHBOARD";
    } 

    function formatBytes($size, $precision = 2) {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($size, 0);
        $power = floor(($bytes ? log($bytes) : 0) / log(1024));
        return round($bytes / pow(1024, $power), $precision) . ' ' . $units[$power];
    }


    public function viewAllOrgData()
    {
        $codes = OrganisationMasterModel::distinct()->pluck('code');
        $uniqueCodes = $codes->toArray();
        $data = array();
        foreach ($uniqueCodes as $code) {
            $organisation = OrganisationMasterModel::where('code', $code)->first(['name', 'id']);
            $userCount = User::where('organisation_id', $organisation->id)->count();
            $fileCount =FileUploadModel::where('organisation_id', $organisation->id)->count();
            $fileSizes = FileUploadModel::where('organisation_id', $organisation->id)->pluck('size')->all();
            $fileDate = FileUploadModel::where('organisation_id', $organisation->id)->max('created_at');
            $fileDate = $fileDate ? Carbon::parse($fileDate)->format('d-M-Y') : null;
            $sizeInBytes = 0;
            foreach ($fileSizes as $size) {
                // Remove any non-numeric characters
                $numericValue = (float) preg_replace('/[^0-9.]/', '', $size);
                // Determine the unit (default to bytes if not specified)
                $unit = strtoupper(preg_replace('/[0-9.]/', '', $size)) ?: 'B';
                switch ($unit) {
                    case 'KB':
                        $sizeInBytes += $numericValue * 1024;
                        break;
                    case 'MB':
                        $sizeInBytes += $numericValue * 1024 * 1024;
                        break;
                    case 'GB':
                        $sizeInBytes += $numericValue * 1024 * 1024 * 1024;
                        break;
                    default:

                        $sizeInBytes += $numericValue;
                        break;
                }
            }
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $power = $sizeInBytes > 0 ? floor(log($sizeInBytes, 1024)) : 0;
            $size = round($sizeInBytes / pow(1024, $power), 2);
            $formattedSize = $size . ' ' . $units[$power];            
            if ($organisation) {
                            $data[$code] = [
                                'name' => $organisation->name,
                                'users' =>   $userCount ,
                                'file'=> $fileCount,
                                'size'=>$formattedSize,
                                'date'=>$fileDate,
                            ];
            } 
            else {
                $data[$code] = null; 
            }
          
        }
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/show-Info">ALL ORGANISATION</a></li>';
        $title="SFMS-$orgcode->code -$module_name";
        return view('admin.Dashboard.showInfo', ['data'=>$data,'breadcrumb'=>$breadcrumb,'title'=>$title]);
    }

    public function viewOwnOrgData(Request $request){
        $id = auth()->user()->organisation_id;
        $data = array();
        $organisation = User::where('id',  $id)->first('organisation_id');  
        // dd($organisation);
        $organisationName = OrganisationMasterModel::where('id',  $id)->first('name');
        $userCount = User::where('organisation_id', $id)->count();
        $fileCount =FileUploadModel::where('organisation_id',$id)->count();
        $fileSizes = FileUploadModel::where('organisation_id', $id)->pluck('size')->all();
        $fileDate = FileUploadModel::where('organisation_id',$id)->max('created_at');
        $fileDate = $fileDate ? Carbon::parse($fileDate)->format('d-M-Y') : null;
        $sizeInBytes = 0;
        foreach ($fileSizes as $size) {
            $numericValue = (float) preg_replace('/[^0-9.]/', '', $size);
            // Determine the unit (default to bytes if not specified)
            $unit = strtoupper(preg_replace('/[0-9.]/', '', $size)) ?: 'B';
            switch ($unit) {
                case 'KB':
                    $sizeInBytes += $numericValue * 1024;
                    break;
                case 'MB':
                    $sizeInBytes += $numericValue * 1024 * 1024;
                    break;
                case 'GB':
                    $sizeInBytes += $numericValue * 1024 * 1024 * 1024;
                    break;
                default:
                    $sizeInBytes += $numericValue;
                    break;
            }
        }
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $sizeInBytes > 0 ? floor(log($sizeInBytes, 1024)) : 0;
        $size = round($sizeInBytes / pow(1024, $power), 2);
        $formattedSize = $size . ' ' . $units[$power]; 
       

        
        $data[1] = [
            'name' => $organisationName->name,
            'users' =>   $userCount ,
            'file'=> $fileCount,
            'size'=>$formattedSize,
            'date'=>$fileDate,
        ];
  
        $orgid = auth()->user()->organisation_id;
        $orgcode= OrganisationMasterModel::where('id', $orgid)->first();
        $module_name=$this->module_name;
        $breadcrumb = '<li class="breadcrumb-item active">' . $orgcode->code . '</li><li class="breadcrumb-item active">'.$module_name.' </li> <li class="breadcrumb-item active"><a href="/home">DASHBOARD</a></li>';
       $title="SFMS-$orgcode->code -$module_name";
    return view('home', ['data'=>$data,'breadcrumb'=>$breadcrumb,'title'=>$title]);

    }


    // public function viewOwnOrgData(Request $request){
    //     // dd($request);
    //     $Name = auth()->user()->name;
    //     $id = auth()->user()->organisation_id;
    //     // dd($Name);
    //     $data = array();
    //     // $organisation = User::where('id',  $id)->first('organisation_id');
    //     // dd( $organisation->organisation_id);
        
    //     $organisationName = OrganisationMasterModel::where('id',  $id)->first('name');
    //     // dd($organisationName->name);
    //     $userCount = User::where('organisation_id', $id)->count();
    //     $fileCount =FileUploadModel::where('organisation_id', $id)->count();
    //     $fileSizes = FileUploadModel::where('organisation_id', $id)->pluck('size')->all();
    //     $fileDate = FileUploadModel::where('organisation_id',$id)->max('created_at');
    //     // dd($fileDate);
    //     $fileDate = $fileDate ? Carbon::parse($fileDate)->format('d-M-Y') : null;
    //     $sizeInBytes = 0;
    //     foreach ($fileSizes as $size) {
    //         // Remove any non-numeric characters
    //         $numericValue = (float) preg_replace('/[^0-9.]/', '', $size);
    //         // Determine the unit (default to bytes if not specified)
    //         $unit = strtoupper(preg_replace('/[0-9.]/', '', $size)) ?: 'B';
    //         switch ($unit) {
    //             case 'KB':
    //                 $sizeInBytes += $numericValue * 1024;
    //                 break;
    //             case 'MB':
    //                 $sizeInBytes += $numericValue * 1024 * 1024;
    //                 break;
    //             case 'GB':
    //                 $sizeInBytes += $numericValue * 1024 * 1024 * 1024;
    //                 break;
    //             // Add more cases if needed for other units
    //             default:
    //                 // Assume the size is already in bytes
    //                 $sizeInBytes += $numericValue;
    //                 break;
    //         }
    //     }
    //     $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    //     $power = $sizeInBytes > 0 ? floor(log($sizeInBytes, 1024)) : 0;
    //     $size = round($sizeInBytes / pow(1024, $power), 2);
    //     $formattedSize = $size . ' ' . $units[$power]; 
       

        
    //     $data[1] = [
    //         'name' => $organisationName->name,
    //         'users' =>   $userCount ,
    //         'file'=> $fileCount,
    //         'size'=>$formattedSize,
    //         'date'=>$fileDate,
    //     ];
    // // dd($data);


    // return view('home', ['data'=>$data]);
  


    // }


}
