<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Contractor extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public function mobile()
    {
        return $this->morphOne(MobileWorker::class, 'user', 'user_type', 'user_id', 'id');
    }
    public function email()
    {
        return $this->morphOne(EmailWorker::class, 'user', 'user_type', 'user_id', 'id');
    }

    public function workType()
    {
        return $this->belongsTo(WorkType::class);
    }
    public function getNameAttribute()
    {
        $name =  $this->first_name;
        $json = json_decode($name, true);

        if ((app()->getLocale() == 'ar' && empty($json['ar'])) || app()->getLocale() == 'hb') {
            return $json['hb'];
        } else {
            return $json['ar'];
        }
    }
   
    public function getFnameAttribute()
    {
        $name =  $this->father_name;
        $json = json_decode($name, true);

        if ((app()->getLocale() == 'ar' && empty($json['ar'])) || app()->getLocale() == 'hb') {
            return $json['hb'];
        } else {
            return $json['ar'];
        }
    }
    public function getGnameAttribute()
    {
        $name =  $this->grand_name;
        $json = json_decode($name, true);

        if ((app()->getLocale() == 'ar' && empty($json['ar'])) || app()->getLocale() == 'hb') {
            return $json['hb'];
        } else {
            return $json['ar'];
        }
    }
    public function getFaNameAttribute()
    {
        $name =  $this->family_name;
        $json = json_decode($name, true);

        if ((app()->getLocale() == 'ar' && empty($json['ar'])) || app()->getLocale() == 'hb') {
            return $json['hb'];
        } else {
            return $json['ar'];
        }
    }

}
