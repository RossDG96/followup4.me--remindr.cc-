<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountSettings extends Controller
{
    public function defaultSnoozeDuration(){
        return 7; 
    }
}
