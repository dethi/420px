<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Models\Image;

$images = Image::all();
?>

<?php include __DIR__.'/fragments/header.php'; ?>
<?php if (Auth::check()) : ?>
<p>
    Hello <?php echo Auth::user()->name; ?>
</p>
<?php endif; ?>

<h1>Welcome to 420px</h1>

<?php foreach ($images as $img) : ?>
<img src="/storage/<?php echo $img->filename; ?>">
<?php endforeach; ?>

<?php include __DIR__.'/fragments/footer.php'; ?>