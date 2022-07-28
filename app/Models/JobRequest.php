<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobRequest extends Model
{
    use HasFactory;
    public function Job(){
        return $this->BelongsTo(Job::class);
    }
    public function Contrator()
    {
        return $this->BelongsTo(Contractor::class);
    }
    public function worker()
    {
        return $this->BelongsTo(Worker::class);
    }
}
