<?php
use App\Auth;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>420px</title>

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="/assets/css/materialize.min.css"  media="screen,projection"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<nav>
    <div class="nav-wrapper">
        <a href="/" class="brand-logo">420px</a>

        <?php if (Auth::check()) : ?>
            <ul class="right hide-on-med-and-down">
                <li><a href="/upload.php"><i class="material-icons">file_upload</i></a></li>
                <li><a href="/user.php"><i class="material-icons">account_circle</i></a></li>
                <li><a href="/logout.php"><i class="material-icons">power_settings_new</i></a></li>
            </ul>
        <?php else : ?>
            <ul class="right hide-on-med-and-down">
                <li><a href="/login.php">LOGIN</a></li>
                <li><a href="/signup.php">SIGN UP</a></li>
            </ul>
        <?php endif; ?>
    </div>
</nav>

<div class="container">