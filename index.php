<?php
session_start();
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
/* -----------------------------------
    Register The autoload
*/
require __DIR__ . '/lib/Application.php';


/*
 * Run The Application
*/

$app = Application::boot();


