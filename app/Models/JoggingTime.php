<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoggingTime extends Model
{
    use HasFactory;

    protected $fillable = ['time_mins', 'date', 'distance', 'user_id'];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
