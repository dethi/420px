<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Models\User;
use App\Auth;
use App\Utils;

Utils::redirectIfAuth("/");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = User::create($_POST['name'], $_POST['email'], $_POST['password']);

    try {
        $user->save();

        Auth::attempt($_POST['email'], $_POST['password']);
        Utils::redirectTo("/");
    } catch (PDOException $e) {
        $error = "Cannot create the user accounts. Please try another with another email.";
    }
}

?>

<?php include(__DIR__.'/fragments/header.php'); ?>
<h1>Sign Up</h1>

<?php if (!empty($error)) : ?>
<p>ERROR: <?php echo $error ?>
<?php endif; ?>

<form name="signup" action="/signup.php" method="POST">
    <p>Name: <input type="text" name="name" /></p>
    <p>Email: <input type="text" name="email" /></p>
    <p>Password: <input type="password" name="password" /></p>
    <p><input type="submit" value="Sign Up" /></p>
</form>
<?php include(__DIR__.'/fragments/footer.php'); ?>