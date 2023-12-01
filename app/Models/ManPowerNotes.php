<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManPowerNotes extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function doneBy()
    {
        return $this->belongsTo(User::class,'done_by','id');
    }
}