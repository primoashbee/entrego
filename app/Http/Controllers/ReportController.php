<?php

namespace App\Http\Controllers;

use App\Models\ManPower;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ReportController extends Controller
{
    public function index(Request $request, $type)
    {
        switch($type){
            case 'success-rate':
                if($request->has('export')){
                    return $this->export($request, 'success-rate');
                }
                return $this->successRate($request);
            case 'fulfillment-rate':
                if($request->has('export')){
                    return $this->export($request, 'fulfillment-rate');
                }
                return $this->fulfillmentRate($request);

        }
    }

    private function successRate($request)
    {
        $list = $this->getSuccessRateData($request);
        return view('reports.success-rate', compact('list'));
    }

    private function fulfillmentRate($request)
    {
        $list = $this->getFulfillmentRateData($request);
        return view('reports.fulfillment-rate', compact('list'));

    }

    private function getFulfillmentRateData($request){
        $start = $request->start_date;
        $end = $request->end_date;
        $stmt = "
        SELECT  
        mp.job_title,
        vacancies AS requested,
        CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND deployed_at IS NOT NULL) ELSE 0 END AS deployed,
        CONCAT(CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND deployed_at IS NOT NULL) ELSE 0 END, '/' , vacancies) AS fulfillment_rate,

        CASE WHEN TRUE THEN (
            SELECT ROUND(AVG(ABS(DATEDIFF(applied_at, deployed_at))), 0) AS avg_tth 
            FROM 
                user_job_applications 
            WHERE deployed_at IS NOT NULL 
            AND 
                user_job_applications.`man_power_id` = mp.id
            ) ELSE 0 END AS avg_tth
        FROM man_powers mp 
        WHERE 1=1
        ";
        if($start){
            $stmt .= " AND expires_at BETWEEN :start AND :end";
        }

        if($start){
            $list =  DB::select($stmt, ['start'=>$start, 'end'=>$end]);
        }else{
            $list =  DB::select($stmt);
        }
        return $list;
    }
    private function getSuccessRateData($request){
        $start = $request->start_date;
        $end = $request->end_date;
        $stmt = "
                    SELECT 
                    mp.id, mp.job_title,
                    CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND applied_at IS NOT NULL) ELSE 0 END AS applied,
                    CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND interview_date IS NOT NULL) ELSE 0 END AS interviewed,
                    CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND rejected_at IS NOT NULL) ELSE 0 END AS rejected,
                    CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND job_offer_accepted_at IS NOT NULL) ELSE 0 END AS approved,
                    CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND job_offered_at IS NOT NULL) ELSE 0 END AS job_offer,
                    CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND deployed_at IS NOT NULL) ELSE 0 END AS deployed,
                    sr.success_rate
                FROM man_powers AS mp
                LEFT JOIN 
                    (
                    SELECT ROUND((sq.deployed / sq.applied)  * 100,2) AS success_rate, sq.man_power_id AS man_power_id FROM (SELECT 
                        CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND applied_at IS NOT NULL) ELSE 0 END AS applied,
                        CASE WHEN TRUE THEN (SELECT COUNT(*) FROM user_job_applications WHERE man_power_id = mp.id AND deployed_at IS NOT NULL) ELSE 0 END AS deployed,
                        mp.id AS man_power_id
                        FROM man_powers AS mp
                        ) AS sq
                    ) AS sr
                ON mp.id = sr.man_power_id 
                WHERE mp.expires_at < :now
            ";
        if($start){
            if($start){
                $stmt .= " AND expires_at BETWEEN :start AND :end";
            }
        }

        if($start){
            $list = DB::select($stmt,['now'=>now(), 'start'=>$start, 'end'=>$end]);    

        }else{
            $list = DB::select($stmt,['now'=>now()]);    
        }

        return $list;
    }
    private function export($request, $type )
    {        
        $viewer = App::make('dompdf.wrapper'); 
        // return view('job-applications.report', compact('applicants'));
        $id = Str::uuid();
        $parameters = $request;
        switch($type){
            case 'success-rate':
                $list = $this->getSuccessRateData($request);
                $pdf = $viewer->loadView('reports.templates.success-rate', compact('list', 'parameters'))->setPaper('legal', 'landscape');
                return $pdf->download("REPORT $id.pdf");
                break;
            case 'fulfillment-rate':
                $list = $this->getFulfillmentRateData($request);
                $pdf = $viewer->loadView('reports.templates.fulfillment-rate', compact('list','parameters'))->setPaper('legal', 'landscape');
                return $pdf->download("REPORT $id.pdf");
                break;

        }
    }
}

