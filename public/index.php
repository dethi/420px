<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Models\Image;

$images = Image::all();
?>

<?php include __DIR__.'/fragments/header.php'; ?>
<h1>Welcome to 420px</h1>

<?php foreach ($images as $img) : ?>
    <a href="/user.php?id=<?php echo $img->user_id; ?>">
        <img src="/storage/<?php echo $img->filename; ?>">
    </a>
<?php endforeach; ?>

<?php include __DIR__.'/fragments/footer.php'; ?>