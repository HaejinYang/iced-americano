<?php
require_once __DIR__.'/vendor/autoload.php';

use Thumbsupcat\IcedAmericano\Routing\Route;
use Thumbsupcat\IcedAmericano\Routing\Middleware;
use Thumbsupcat\IcedAmericano\Session\DatabaseSessionHandler;
use Thumbsupcat\IcedAmericano\Database\Adaptor;

Adaptor::setup('mysql:dbname=iced-americano;host=127.0.0.1;port=5051', 'coffee', 'asdlkkofkqwpdads');
session_set_save_handler(new DatabaseSessionHandler());
session_start();

$_SESSION['message'] = 'hello world';
$_SESSION['foo'] = new stdClass();

var_dump("helloworld");

// epdl