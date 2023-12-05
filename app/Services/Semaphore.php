<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Semaphore {
    
    protected $api_key;

    const API_HOST = [ 
        'MESSAGING' => "https://api.semaphore.co/api/v4/messages"
    ];

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
 
    }

    public function sendSMS($number, $message, $sender = 'SEMAPHORE')
    {
        if(env('APP_ENV') != 'local'){
            return Http::post(self::API_HOST['MESSAGING'],
                [
                    'apikey'=>$this->api_key,
                    'number'=>$number,
                    'message'=>$message,
                    'sendername'=>$sender
                ]
            );
        }
        return true;
    }
}