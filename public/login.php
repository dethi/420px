<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;

Utils::redirectIfAuth("/");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    try {
        $ok = Auth::attempt($_POST['email'], $_POST['password']);
        if ($ok) {
            Utils::redirectTo("/");
        }
    } catch (PDOException $e) {
        $error = "An error occured. Please try later.";
    }
}

?>

<?php include(__DIR__.'/fragments/header.php'); ?>
<h1>Login</h1>

<?php if (!empty($error)) : ?>
<p>ERROR: <?php echo $error ?>
<?php endif; ?>

<?php if (!empty($ok)) : ?>
<p>Invalid email or password</p>
<?php endif; ?>

<form name="login" action="/login.php" method="POST">
    <p>Email: <input type="text" name="email" /></p>
    <p>Password: <input type="password" name="password" /></p>
    <p><input type="submit" value="Login" /></p>
</form>
<?php include(__DIR__.'/fragments/footer.php'); ?>