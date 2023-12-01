<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserArchiveLogs extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function getStatusNameAttribute()
    {
        return $this->status === 1 ? 'Active' : 'Archived';
    }

    public function doneBy()
    {
        return $this->belongsTo(User::class,'done_by','id');
    }

}
