<?php

namespace App\Models;

use App\Models\User;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRequirement extends Model
{
    use HasFactory;
    protected $guarded = [];
    const MISSING  = "MISSING";
    const PENDING_FOR_APPROVAL = "PENDING_FOR_APPROVAL";
    const REJECTED = "REJECTED";
    const APPROVED = "APPROVED";

    public function requirement(){
        return $this->belongsTo(Requirement::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function isUploaded()
    {
        return $this->status != self::MISSING;
    }

    public function storedFileName()
    {
        $req_name = $this->requirement->name;
        $ext = $this->extension;
        $uuid = $this->user->uuid;
        return  "$uuid-$req_name.$ext";
    }
    public function outputFileName()
    {
        $req_name = $this->requirement->name;
        $ext = $this->extension;
        $name = $this->user->fullname;
        return  "$name-$req_name.$ext";
    }
}
