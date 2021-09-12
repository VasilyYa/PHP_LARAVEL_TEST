<?php

$documentRoot = $_SERVER['DOCUMENT_ROOT'];
require_once $documentRoot . 'app/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Models\Database;
use App\Api\ContactsApi;

//echo $_SERVER['REQUEST_URI'];

try {

    $dotenv = Dotenv::create($documentRoot . '/config/');
    $dotenv->load();
    new Database();

    $api = new ContactsApi();

    echo $api->run();

} catch (Exception $e) {

    echo json_encode(Array('error' => $e->getMessage()));
}

