<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Models\Image;

$images = Image::all();
?>

<?php include __DIR__.'/fragments/header.php'; ?>
<?php foreach ($images as $img) : ?>
    <a href="/user.php?id=<?= $img->user_id ?>">
        <img src="/storage/<?= $img->filename ?>">
    </a>
<?php endforeach; ?>
<?php include __DIR__.'/fragments/footer.php'; ?>