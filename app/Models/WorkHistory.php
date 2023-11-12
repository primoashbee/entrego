<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkHistory extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function getStartDateFormattedAttribute()
    {
        return Carbon::parse($this->start_date)->format('F m, Y');
    }
    public function getEndDateFormattedAttribute()
    {
        return Carbon::parse($this->end_date)->format('F m, Y');
    }
}
