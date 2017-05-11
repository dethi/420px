<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Models\User;
use App\Auth;
use App\Utils;
use App\Csrf;

Utils::redirectIfAuth("/");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::check($_POST['_token']);

    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $ok = $name != null
        && $email != null
        && filter_var($email, FILTER_VALIDATE_EMAIL)
        && $password != null;
    if ($ok) {
        $user = User::create($name, $email, $password);
        try {
            $user->save();

            Auth::attempt($email, $password);
            Utils::redirectTo("/");
        } catch (PDOException $e) {
            $error = 'Cannot create the user accounts. Please try another with another email.';
        }
    } else {
        $error = 'Invalid fields values.';
    }
}
?>

<?php include(__DIR__.'/fragments/header.php'); ?>
<?php if (!empty($error)) : ?>
<p>ERROR: <?= $error ?>
<?php endif; ?>

<form name="signup" action="/signup.php" method="POST">
    <?= Csrf::field() ?>

    <div class="input-field">
        <i class="material-icons prefix">account_circle</i>
        <input id="name" name="name" type="text" class="validate">
        <label for="name">Name</label>
    </div>
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
        Sign Up
    </button>
</form>

<?php include(__DIR__.'/fragments/footer.php'); ?>