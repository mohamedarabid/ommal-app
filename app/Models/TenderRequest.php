<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderRequest extends Model
{
    use HasFactory;
    public function currency()
    {
        return $this->belongsTo(currency::class);
    }
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
