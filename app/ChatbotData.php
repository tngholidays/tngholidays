<?php

    namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatbotData extends Model
{
    protected $table = 'chatbotdata';
    protected $dates = ['deleted_at'];


    function __construct()
    {
        
        parent::__construct();
          
          
    }
    
}

