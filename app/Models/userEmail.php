<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userEmail extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'user_id'];

    /**
     * This email account belongs to a user
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}