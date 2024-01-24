<?php

namespace App\Console\Commands;

use App\Models\FileUploadModel;
use App\Models\OrganisationMasterModel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class DailyEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyEmailCorn:cron';

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
            $todayDate = today();
            $file = FileUploadModel::select('name', 'created_at', 'added_by','size','size_in_bytes')
                ->where('org_code', $code)
                ->where(DB::raw('DATE(created_at)'), $todayDate)
                ->get();
                // $organisation[$code]=$file;
                // $organisation[$code]['org']= $name;
                $organisation[$code] = [
                    'name' => $name,
                    'files' => $file,
                ];
        }
    //    dd($organisation);
       $todaysDate = today()->format('j-M-Y');
        $data["title"] = "SFMS | Documents Transferred Today  ". $todaysDate;
        $data["time"]="today";
        $data["body"] = $todaysDate;
        $data["names"]=$organisation;
        Mail::send('emailCorn', $data, function ($message) use ( $data, $todaysDate) {
          $message->to('dev10@scube.net.in')
                //   ->cc('ceo@devharshinfotech.com')
                //   ->cc(' rakeshshah900@gmail.com')
                //   ->cc(' dtp@devharshinfotech.com')
                  
            ->subject("SFMS | Documents Transferred Today ".  $todaysDate);
        });

    
        // $codes = OrganisationMasterModel::distinct()->pluck('code');
        // $uniqueCodes = $codes->toArray();

        // foreach ($uniqueCodes as $code) {
        //     $emails = OrganisationMasterModel::where('code', $code)->pluck('email')->toArray();
        //     //get daily uploaded file
           
        //     $todayDate = today();

        //     $file = FileUploadModel::select('name', 'created_at', 'added_by')
        //         ->where('org_code', $code)
        //         ->where(DB::raw('DATE(created_at)'), $todayDate)
        //         ->get();
        //     //  dd($file);   

        //     $validatedEmails = array_map('trim', $emails);
        //     $validatedEmails = array_filter($validatedEmails, 'filter_var', FILTER_VALIDATE_EMAIL);
        //     $todaysDate = today()->toDateString();
        //     $data["title"] = "File Uploaded on today( ".$todaysDate .")";
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
