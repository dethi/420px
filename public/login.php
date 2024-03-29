<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;
use App\Csrf;

Utils::redirectIfAuth("/");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::check($_POST['_token']);

    try {
        $ok = Auth::attempt($_POST['email'], $_POST['password']);
        if ($ok) {
            Utils::redirectTo("/");
        } else {
            $error = "Email/password doesn't match";
        }
    } catch (PDOException $e) {
        $error = "An error occured. Please try later.";
    }
}
?>

<?php include(__DIR__.'/fragments/header.php'); ?>
<?php if (!empty($error)) : ?>
<p>ERROR: <?= $error ?>
<?php endif; ?>

<?php if (!empty($ok)) : ?>
<p>Invalid email or password</p>
<?php endif; ?>

<div class="row">
    <div class="col s6 offset-s3">
        <form name="login" action="/login.php" method="POST">
            <?= Csrf::field() ?>

            <div class="input-field">
                <i class="material-icons prefix">email</i>
                <input id="email" name="email" type="email" class="validate">
                <label for="email">Email</label>
            </div>
            <div class="input-field">
                <i class="material-icons prefix">lock</i>
                <input id="password" name="password" type="password" class="validate">
                <label for="password">Password</label>
            </div>

            <button class="btn waves-effect waves-light" type="submit" name="action">
                Login
            </button>
        </form>
    </div>
</div>
<?php include(__DIR__.'/fragments/footer.php'); ?>