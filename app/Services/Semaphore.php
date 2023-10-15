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
        $response = Http::post(self::API_HOST['MESSAGING'],
                [
                    'apikey'=>config('services.semaphore.api_key'),
                    'number'=>'09685794313',
                    'message'=>'Why are you not sending?',
                    'sendername'=>'SEMAPHORE'
                ]);
        dd($response->json());
    }
}