<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailWorker extends Model
{
    use HasFactory;
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
    public function Contractor()
    {
        return $this->belongsTo(Contractor::class);
    }
    public function user()
    {
        return $this->morphTo();
    }
}
