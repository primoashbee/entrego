<?php

namespace App\Http\Controllers;

use App\Models\ManPower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request, $type)
    {
        switch($type){
            case 'success-rate':
                return $this->successRate($request);
            case 'fulfillment-rate':
                return $this->fulfillmentRate($request);

        }
    }

    private function successRate($request)
    {
        $list = ManPower::with('applications')->get();
  
        $list = DB::select("
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
                ",['now'=>now()]);    
        return view('reports.success-rate', compact('list'));
    }

    private function fulfillmentRate($request)
    {
        $list =  DB::select("
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
        FROM man_powers mp WHERE expires_at < NOW();
        ");

        return view('reports.fulfillment-rate', compact('list'));

    }
}

