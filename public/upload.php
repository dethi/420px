<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Csrf;
use App\Auth;
use App\Utils;
use App\Models\Image;

Utils::redirectIfGuest("/");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Csrf::check($_POST['_token']);

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
<?php if (!empty($error)) : ?>
    <p>ERROR: <?= $error ?>
<?php elseif (!empty($filename)) : ?>
    <div>
        <img src="/storage/<?= $filename ?>">
    </div>
<?php endif; ?>

<form name="upload" action="/upload.php" method="POST" enctype="multipart/form-data">
    <?= Csrf::field() ?>

    <div class="file-field input-field">
        <div class="btn">
            <span>File</span>
            <input type="file" name="image">
        </div>
        <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
        </div>
    </div>

    <button class="btn waves-effect waves-light" type="submit" name="action">
        Upload <i class="material-icons right">file_upload</i>
    </button>
</form>


<?php include(__DIR__.'/fragments/footer.php'); ?>