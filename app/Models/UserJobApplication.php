<?php

namespace App\Models;

use App\Models\User;
use App\Models\ManPower;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserJobApplication extends Model
{
    use HasFactory;

    protected $guarded = [];

    const APPLIED = "APPLIED";
    const WAITING_FOR_EXAM_RESULT = "WAITING_FOR_EXAM_RESULT";
    const EXAM_PASSED = "EXAM_PASSED";
    const EXAM_FAILED = "EXAM_FAILED";
    const FOR_SENDING_INTERVIEW = "FOR_SENDING_INTERVIEW";
    const INTERVIEW_SENT = "INTERVIEW_SENT";

    const REJECTED = "REJECTED";
    const APPROVED = "APPROVED";

    const FOR_REQUIREMENTS = "FOR_REQUIREMENTS";
    const EXAM_REVIEWING = "EXAM_REVIEWING";
    
    const HIRED = "HIRED";
    const DEPLOYED = "DEPLOYED";
    const JOB_OFFER = "JOB_OFFER";
    const CANCELLED = "CANCELLED";
    const STATUSES = [
        [
            "value"=> self::APPLIED,
            "label"=> "APPLIED"
        ],
        [
            "value"=> self::EXAM_PASSED,
            "label"=> "EXAM PASSED"
        ],
        [
            "value"=> self::EXAM_FAILED,
            "label"=> "EXAM FAILED"
        ],
        [
            "value"=> self::INTERVIEW_SENT,
            "label"=> "INTERVIEW SENT"
        ],
        [
            "value"=> self::FOR_SENDING_INTERVIEW,
            "label"=> "FOR SENDING INTERVIEW"
        ],
        [
            "value"=> self::REJECTED,
            "label"=> "REJECTED"
        ],
        [
            "value"=> self::APPROVED,
            "label"=> "APPROVED"
        ],
        [
            "value"=> self::FOR_REQUIREMENTS,
            "label"=> "FOR REQUIREMENTS"
        ],
        [
            "value"=> self::JOB_OFFER,
            "label"=> "JOB OFFER"
        ],
        [
            "value"=> self::DEPLOYED,
            "label"=> "DEPLOYED"
        ],
        [
            "value"=> self::CANCELLED,
            "label"=> "CANCELLED"
        ],
        [
            "value"=> self::EXAM_REVIEWING,
            "label"=> "EXAM REVIEWING"
        ]
    ];
    
    const IN_PROGRESS = [
            self::WAITING_FOR_EXAM_RESULT, 
            self::WAITING_FOR_EXAM_RESULT, 
            self::EXAM_PASSED, 
            self::EXAM_FAILED,
            self::FOR_SENDING_INTERVIEW,
            self::INTERVIEW_SENT,
            self::FOR_REQUIREMENTS,
            self::EXAM_REVIEWING
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(ManPower::class,'man_power_id','id');
    }

    public function getStatusNameAttribute()
    {
        return str_replace('_',' ', $this->status);
    }

    public function userQuiz()
    {
        return $this->hasOne(UserQuiz::class,'application_id');
    }
    
    public function canBeDeployed()
    {
        return $this->user->requirementsFullfilled();
    }

    public function scopeActive()
    {
        return $this->whereNotIn('status', [self::APPLIED, self::REJECTED, self::DEPLOYED, self::CANCELLED]);
    }

    public function scopeDeployed()
    {
        return $this->where('status', self::DEPLOYED);
    }

    public static function variation($date)
    {   
        $last = self::whereMonth('created_at', $date->copy()->subMonth()->month)->count() ;
        $now = self::whereMonth('created_at', $date->month)->count();
     
        if($last == 0){
            $variaton = 100;
        }else{
            $variaton = round(1 * abs(100 - (($now / $last) * 100)),2);

            if($last > $now){
                $variaton = round(-1 * abs(100 - (($now / $last) * 100)),2);
            }
        }

       return $variaton;
    }

    public static function variationDeployed($date)
    {   
        $last = self::whereMonth('created_at', $date->copy()->subMonth()->month)->count() ;
        $now =  self::whereMonth('created_at', $date->format('Y'))->deployed()->count();
     
        if($last == 0){
            $variaton = 100;
        }else{
            $variaton = round(1 * abs(100 - (($now / $last) * 100)),2);

            if($last > $now){
                $variaton = round(-1 * abs(100 - (($now / $last) * 100)),2);
            }
        }

       return $variaton;
    }

    public function hiringTimeSpan()
    {
        $diff = Carbon::parse($this->deployed_at)->diffInDays($this->created_at);
        $days = 'day';
        if($diff > 1){
            $days = 'days';
        }
        if($diff  == 0 || $diff == 1){
           return "1 day Time to Hire";
        }

        return  "$diff $days Time to Hire";
    }

    public function getInterviewDateFriendlyAttribute()
    {
        if(is_null($this->interview_date)){
            return '-';
        }
        return Carbon::parse($this->interview_date);
    }

    public function getJobOfferedAtFriendlyAttribute()
    {
        if(is_null($this->job_offered_at)){
            return '-';
        }
        return Carbon::parse($this->job_offered_at);
    }

    public function getJobOfferAcceptedAtFriendlyAttribute()
    {
        if(is_null($this->job_offer_accepted_at)){
            return '-';
        }
        return Carbon::parse($this->job_offer_accepted_at);
    }

    public function getDeployedAtFriendlyAttribute()
    {
        if(is_null($this->deployed_at)){
            return '-';
        }
        return Carbon::parse($this->deployed_at);
    }

    public function steps()
    {
        
        //Apply > Waiting for Exam Result | For sending interview > Interview Sent >  JOB OFFER > Job Offer Accepted > Deployed	
        
        $steps = collect([
            [
                'label'=>'Applied',
                'key'=> self::APPLIED,
                'date'=>$this->created_at,
                'data'=> [
                    'application'=> $this,
                    'notes'=> 'Applied on job listing page'
                ],
                'class'=> '',
                'finished'=>true,
                'processor'=> $this->user
            ],

            [
                'label'=>'Interview Sent',
                'key'=> self::INTERVIEW_SENT,
                'date'=> $this->interview_sent_at,
                'data'=> [
                    'application'=> $this,
                    'notes'=>$this->send_interview_notes
                ],
                'class'=> isset($this->interview_sent_at) ? 'active' : '',
                'finished'=> isset($this->interview_sent_at) ? true : false,
                'processor'=> $this->interviewer

            ],
            [
                'label'=>'Job Offer Sent',
                'key'=> self::JOB_OFFER,
                'date'=> $this->offered_at,
                'data'=> [
                    'application'=> $this,
                    'notes'=>$this->job_offer_notes
                ],
                'class'=> isset($this->offered_at) ? 'active' : '',
                'finished'=>isset($this->offered_at) ? true : false ,
                'processor'=> $this->jobOfferer

            ],
            [
                'label'=>'Job Offer Accepted',
                'key'=> self::FOR_REQUIREMENTS,
                'date'=> $this->job_offer_accepted_at,
                'data'=> [
                    'application'=> $this,
                    'notes'=> $this->accepted_job_offer_notes
                ],
                'class'=> isset($this->job_offer_accepted_at) ? 'active' : '',
                'finished'=>isset($this->job_offer_accepted_at) ? true : false ,
                'processor'=> $this->jobOfferAcceptor

            ],
            
            [
                'label'=>'Deployed',
                'key'=> self::DEPLOYED,
                'date'=> $this->deployed_at,
                'data'=> [
                    'application'=> $this,
                    'notes'=>$this->deployed_notes
                ],
                'class'=> isset($this->deployed_at) ? 'active' : '',
                'finished'=>isset($this->deployed_at) ? true : false ,
                'processor'=> $this->deployer

            ],
            

        ]);

        $cancelled = [
            'label'=>'Cancelled',
            'key'=>self::CANCELLED,
            'date'=>$this->cancelled_at,
            'data'=> [
                'notes'=> $this->cancelled_notes
            ],
            'class'=> 'active text-center',
            'finished'=>true
        ];

        $last_activity = $this->lastActivity();
        $last_step = $last_activity['status'];
        if($this->job->has_sjt){
            $notes = 'Pending Exam';
            $quiz = $this->userQuiz;
            if($quiz && $quiz->is_passed){
                $score = $quiz->score;
                $questions = $quiz->answersv2()->count();
                $notes = "Examination Passed. Score: $score/$questions";
            }
            $exam =  [
                'label'=>'Exam Result',
                // 'key'=> self::WAITING_FOR_EXAM_RESULT,
                'key'=> 'Exam Result',
                'date'=>$quiz ? $quiz->created_at : null,
                'data'=> [
                    'quiz'=>$quiz,
                    'notes'=> $notes
                ],
                'class'=>$quiz ? 'active text-center' : '',
                'finished'=>$quiz ? true : false,
                'processor' => $this->user
            ];
            $steps->splice(1, 0, [$exam]);

        }


        if($this->status ==  self::INTERVIEW_SENT){
            $steps = $steps->map(function($step){
                if($step['key'] == self::INTERVIEW_SENT){
                    return [
                        'label'=>'Interview sent',
                        'key'=> self::INTERVIEW_SENT,
                        'date'=> $this->interview_sent_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->send_interview_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->interviewer
                    ];
                }

                return $step;
            });

            // if($last_step == self::INTERVIEW_SENT){
            //     dd('hey');
            // }
        }

        if($this->status ==  self::JOB_OFFER){
            $steps = $steps->map(function($step){
                if($step['key'] == self::INTERVIEW_SENT){
                    return [
                        'label'=>'Interview sent',
                        'key'=> self::INTERVIEW_SENT,
                        'date'=> $this->interview_sent_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->send_interview_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->interviewer

                    ];
                }
                if($step['key'] == self::JOB_OFFER){
                    return [
                        'label'=>$step['label'],
                        'key'=> $step['key'],
                        'date'=> $this->job_offered_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->job_offer_notes

                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->offerer

                    ];
                }
                return $step;
            });
        }

        

        if($this->status ==  self::FOR_REQUIREMENTS){
            $steps = $steps->map(function($step){
                if($step['key'] == self::INTERVIEW_SENT){
                    return [
                        'label'=>'Interview sent',
                        'key'=> self::INTERVIEW_SENT,
                        'date'=> $this->interview_sent_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->send_interview_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->interviewer

                    ];
                }
                if($step['key'] == self::JOB_OFFER){
                    return [
                        'label'=>$step['label'],
                        'key'=> $step['key'],
                        'date'=> $this->job_offered_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->job_offer_notes

                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->oferrer

                    ];
                }
                if($step['key'] == self::FOR_REQUIREMENTS){
                    return [
                        'label'=>$step['label'],
                        'key'=> $step['key'],
                        'date'=> $this->job_offer_accepted_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->accepted_job_offer_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->jobOfferAcceptor

                    ];
                }
                return $step;
            });
        }
        if($this->status ==  self::DEPLOYED){
            $steps = $steps->map(function($step){
                if($step['key'] == self::INTERVIEW_SENT){
                    return [
                        'label'=>'Interview sent',
                        'key'=> self::INTERVIEW_SENT,
                        'date'=> $this->interview_sent_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->send_interview_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->interviewer

                    ];
                }
                if($step['key'] == self::JOB_OFFER){
                    return [
                        'label'=>$step['label'],
                        'key'=> $step['key'],
                        'date'=> $this->job_offered_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->job_offer_notes

                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->jobOfferer

                    ];
                }
                if($step['key'] == self::FOR_REQUIREMENTS){
                    return [
                        'label'=>$step['label'],
                        'key'=> $step['key'],
                        'date'=> $this->job_offer_accepted_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->accepted_job_offer_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->jobOfferAcceptor

                    ];
                }
                if($step['key'] == self::DEPLOYED){
                    return [
                        'label'=>$step['label'],
                        'key'=> $step['key'],
                        'date'=> $this->deployed_at,
                        'data'=> [
                            'application'=> null,
                            'notes'=> $this->deployed_notes
                        ],
                        'class'=>'active text-center',
                        'finished'=>true,
                        'processor'=>$this->deployer

                    ];
                }
                return $step;
            });
        }
        return $steps;
    }

    public function interviewer()
    {
        return $this->belongsTo(User::class, 'interviewed_by','id');
    }

    public function deployer()
    {
        return $this->belongsTo(User::class, 'deployed_by','id');
    }

    public function jobOfferer()
    {
        return $this->belongsTo(User::class, 'job_offer_sent_by','id');
    }

    public function jobOfferAcceptor()
    {
        return $this->belongsTo(User::class, 'job_offer_accepted_by','id');
    }

    public function cancellor()
    {
        return $this->belongsTo(User::class, 'cancelled_by','id');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by','id');
    }

    public function lastActivity()
    {
        $applied_at =  $this->applied_at;
        $accepted_at =  $this->accepted_at;
        $interview_date =  $this->interview_sent_at;
        $deployed_at =  $this->deployed_at;
        $job_offered_at =  $this->job_offered_at;
        $job_offer_accepted_at =  $this->job_offer_accepted_at;

        // if($this->status == "CANCELLED")
        $dates = collect([
            [
                'key'=> 'applied_at',
                'status'=> self::APPLIED,
                'value'=> is_null($this->applied_at) ?  null : Carbon::parse($this->applied_at) 
            ],
            [
                'key'=> 'accepted_at',
                'status'=> self::APPROVED,
                'value'=> is_null($this->accepted_at) ?  null : Carbon::parse($this->accepted_at) 
            ],
            [
                'key'=> 'interview_sent_ant',
                'status'=> self::INTERVIEW_SENT,
                'value'=> is_null($this->interview_date) ?  null : Carbon::parse($this->interview_date) 
            ],
            [
                'key'=> 'deployed_at',
                'status'=> self::DEPLOYED,
                'value'=> is_null($this->deployed_at) ?  null : Carbon::parse($this->deployed_at) 
            ],
            [
                'key'=> 'job_offered_at',
                'status'=> self::JOB_OFFER,
                'value'=> is_null($this->job_offered_at) ?  null : Carbon::parse($this->job_offered_at) 
            ],
            [
                'key'=> 'job_offer_accepted_at',
                'status'=> self::FOR_REQUIREMENTS,
                'value'=> is_null($this->job_offer_accepted_at) ?  null : Carbon::parse($this->job_offer_accepted_at) 
            ]
            ]);

        return  $dates->reduce(function ($carry, $item) {
                // Compare the 'value' of the current item with the 'value' of the carry
                // if(!is_null($item['value'])){
                    $new =  $carry['value'] > $item['value'] ? $carry : $item;
                    return $new;
                // }
            },[
                'key'=> 'applied_at',
                'status'=> self::APPLIED,
                'value'=> is_null($this->applied_at) ?  null : Carbon::parse($this->applied_at) 
            ]);

      
    

        
    }

    
}
