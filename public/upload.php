<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;
use App\Models\Image;

Utils::redirectIfGuest("/");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $filename = Utils::saveUploadedImage($_FILES['image'], __DIR__.'/storage');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    if (empty($error)) {
        $user_id = Auth::user()->id;

        try {
            $img = Image::create($filename, $user_id);
            $img->save();
        } catch (PDOException $e) {
            $error = 'An error occured.';
        }
    }
}
?>

<?php include(__DIR__.'/fragments/header.php'); ?>
<h1>Upload</h1>

<?php if (!empty($error)) : ?>
    <p>ERROR: <?= $error ?>
<?php elseif (!empty($filename)) : ?>
    <div>
        <img src="/storage/<?= $filename ?>">
    </div>
<?php endif; ?>

<form name="upload" action="/upload.php" method="POST" enctype="multipart/form-data">
    <p>Select an image: <input type="file" name="image" /></p>
    <p><input type="submit" value="Upload" /></p>
</form>
<?php include(__DIR__.'/fragments/footer.php'); ?>