<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender',
        'recipient',
        'settings',
        'subject',
        'email_date',
        'reminder_date',
        'reminder_period',
        'archive',
        'cc',
        'user_id'
    ];

    /**
     * This email belongs to a user
     */
    public function user(){
        return $this->belongsTo(User::class, 'id');
    }
}
