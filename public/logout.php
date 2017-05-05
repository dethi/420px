<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;

Auth::logout();
Utils::redirectTo("/");
