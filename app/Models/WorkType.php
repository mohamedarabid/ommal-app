<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkType extends Model
{
    use HasFactory;
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
}
