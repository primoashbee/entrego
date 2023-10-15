<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Txtbox {
    
    protected $api_key;

    const API_HOST = [ 
        'MESSAGING' => "https://ws-v2.txtbox.com/messaging/v1/sms/push"
    ];

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $request = Http::post(self::API_HOST['MESSAGING']);
        dd($request);
    }
}