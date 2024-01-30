<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\FileUploadModel;
use App\Models\OrganisationMasterModel;
use Carbon\Carbon;

class weeklyEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weeklyEmailCorn:cron';

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
            // $file = FileUploadModel::select('name', 'created_at', 'added_by', 'size')
            // ->where('org_code', $code)
            // ->where(function ($query) {
            //     $query->where(DB::raw('YEARWEEK(created_at)'), DB::raw('YEARWEEK(NOW()) - 1'))
            //         ->orWhereBetween('created_at', [now()->subDays(8)->startOfDay(), now()->subDays(1)->endOfDay()]);
            // })
            // ->get();
      

            $file = FileUploadModel::select(
                'files.size_in_bytes',
                'files.name',
                'files.size',
                'files.added_by',
                'files.created_at',
                'files.project',
                'files.purpose',
                'projects.name as project'
            )
            ->join('projects', 'files.project', '=', 'projects.id')
            ->where('org_code', $code)
            ->whereBetween('files.created_at', [
                now()->subWeek()->startOfWeek(Carbon::MONDAY)->toDateString(),
                now()->subWeek()->endOfWeek(Carbon::SUNDAY)->toDateString()
            ])
            ->get();
                $organisation[$code] = [
                    'name' => $name,
                    'files' => $file,
                ];
        }
        //    dd($organisation);

        $todayDate = Carbon::today();
        $startDate = now()->subWeek()->startOfWeek(Carbon::MONDAY)->format('d-M-Y');
         $endDate = now()->subWeek()->endOfWeek(Carbon::SUNDAY)->format('d-M-Y');
        // dd( $startDate ,$endDate);
    
        $data["title"] = "SFMS | Documents Transferred in Week ".  $startDate." To  ".   $endDate;
        $data["time"]="in this Week ";
        $data["body"] =   $startDate." To  ".   $endDate ;
        $data["names"]= $organisation;
        Mail::send('emailCorn', $data, function ($message) use ( $data ) {
          $message->to('dev10@scube.net.in')
          ->subject($data["title"]);
        });
       
       
       
        // $codes = OrganisationMasterModel::distinct()->pluck('code');
        // $uniqueCodes = $codes->toArray();

        // foreach ($uniqueCodes as $code) {
        //     $emails = OrganisationMasterModel::where('code', $code)->pluck('email')->toArray();
        //     //get mothly uploaded file
        //     $file = FileUploadModel::select('name', 'created_at', 'added_by')
        //     ->where('org_code', $code)
        //     ->where(function ($query) {
        //         $query->where(DB::raw('YEARWEEK(created_at)'), DB::raw('YEARWEEK(NOW())'));
        //     })
        //     ->get();

        //     $validatedEmails = array_map('trim', $emails);
        //     $validatedEmails = array_filter($validatedEmails, 'filter_var', FILTER_VALIDATE_EMAIL);
            
        //     $data["title"] = "File Uploaded in this Week by User";
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
