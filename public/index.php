<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
?>

<?php include __DIR__.'/fragments/header.php'; ?>
<?php if (Auth::check()) : ?>
<p>
    Hello <?php echo Auth::user()->name; ?>
</p>
<?php endif; ?>

<h1>Welcome to 420px</h1>
<?php include __DIR__.'/fragments/footer.php'; ?>