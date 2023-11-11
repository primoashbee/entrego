<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class  AuditLog extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function log($user_id, $event, $data =[])
    {
        // $user = User::find($user_id)->fullname;
        return self::create([
            'user_id'=>$user_id,
            // 'body'=>"$user: $event",
            'body'=>$event,
            'data'=>json_encode($data)
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
