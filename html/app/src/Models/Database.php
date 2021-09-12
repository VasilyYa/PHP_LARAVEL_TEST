<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database {

    function __construct() {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        // Setup the Eloquent ORM…
        $capsule->bootEloquent();
    }

}