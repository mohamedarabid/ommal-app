<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    public function currency()
    {
        return $this->belongsTo(currency::class);
    }
    public function JobSalary()
    {
        return $this->belongsTo(JobSalary::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function getFnameAttribute()
    {
        $name =  $this->name;
        $json = json_decode($name, true);

        if ((app()->getLocale() == 'ar' && empty($json['ar'])) || app()->getLocale() == 'hb') {
            return $json['hb'];
        } else {
            return $json['ar'];
        }
    }
    public function getFdescAttribute()
    {
        $name =  $this->desc;
        $json = json_decode($name, true);

        if ((app()->getLocale() == 'ar' && empty($json['ar'])) || app()->getLocale() == 'hb') {
            return $json['hb'];
        } else {
            return $json['ar'];
        }
    }
}
