<?php

namespace App\Console\Commands;

use App\Models\FileUploadModel;
use App\Models\OrganisationMasterModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class EmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $organisation=array();
        $codes = OrganisationMasterModel::distinct()->pluck('code');
        $uniqueCodes = $codes->toArray();
        foreach ($uniqueCodes as $code) {
            $organizationInfo = OrganisationMasterModel::where('code', $code)->first();
            $name = $organizationInfo->name;
           
            $file = FileUploadModel::select('files.name', 'files.created_at', 'files.added_by','files.size','files.size_in_bytes','projects.name as project','files.purpose')
            ->leftjoin('projects', 'files.project', '=', 'projects.id')
            ->where('org_code', $code)
            ->where(function ($query) {
                $query->whereYear('files.created_at', now()->subMonth()->year)
                ->whereMonth('files.created_at', now()->subMonth()->month);
            })
            ->get();
             
                $organisation[$code] = [
                    'name' => $name,
                    'files' => $file,
                ];
        }
 
        $previousMonth = today()->subMonth();
        $Month = $previousMonth->format('F');
        $year = $previousMonth->year;
        $data["title"] = "SFMS | Documents Transferred in ".  $Month ."-".$year.".";
        $data["time"]="in the month of";
        $data["body"] = $Month . ' ' . $year;
        $data["names"]=$organisation;
    Mail::send('emailCorn', $data, function ($message) use ( $data,$year,$Month) {
        $message->to('dev10@scube.net.in')
            ->subject("SFMS | Documents Transferred in ".  $Month ." ".$year.".");
    });




        //  $codes = OrganisationMasterModel::distinct()->pluck('code');
        //         $uniqueCodes = $codes->toArray();
        // foreach ($uniqueCodes as $code) {
        //     $emails = OrganisationMasterModel::where('code', $code)->pluck('email')->toArray();
        //     //get mothly uploaded file
        //     $file = FileUploadModel::select('name', 'created_at', 'added_by')
        //     ->where('org_code', $code)
        //     ->where(function ($query) {
        //         $query->where(DB::raw('MONTH(created_at)'), now()->month)
        //               ->where(DB::raw('YEAR(created_at)'), now()->year);
        //     })
        //     ->get();

        //     $validatedEmails = array_map('trim', $emails);
        //     $validatedEmails = array_filter($validatedEmails, 'filter_var', FILTER_VALIDATE_EMAIL);
        //     $Month = today()->format('F');
        //     $year = today()->year;
        //     $data["title"] = "File Uploaded in ".  $Month ."-".$year." Month by User";
        //     $data["body"] = "You have received the following files list. Please check";
        //     $data["regardsName"] = 'SECURE Software Solution';
        //     $data['file_name'] = $file;
        
        //     Mail::send('emailCorn', $data, function ($message) use ($data, $validatedEmails) {
        //         foreach ($validatedEmails as $email) {
        //             $message->to($email, $email);
        //         }
        //         $message->subject($data["title"]);
        //     });
        // }
      

       

       
    }
}
