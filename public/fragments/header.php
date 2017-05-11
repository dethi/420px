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

<?php if (Auth::check()) : ?>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/user.php">My Profile</a></li>
        <li><a href="/upload.php">Upload</a></li>
        <li><a href="/logout.php">Logout</a></li>
    </ul>
<?php else : ?>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/login.php">Login</a></li>
        <li><a href="/signup.php">Sign up</a></li>
    </ul>
<?php endif; ?>
