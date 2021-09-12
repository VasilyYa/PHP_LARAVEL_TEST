<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $timestamps = false;

    protected $table = 'contacts';
    //protected $primaryKey = 'id';

    protected $guarded = [];

/*
    public function getId()
    {
        return $this->id;
    }*/

}