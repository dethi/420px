<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;
use App\Filters;
use App\Models\Image;

Utils::redirectIfGuest("/");

$img = null;
if (!empty($_GET['img_id'])) {
    $imgId = $_GET['img_id'];
    if (filter_var($imgId, FILTER_VALIDATE_INT)) {
        try {
            $img = Image::find($imgId);
        } catch (PDOException $e) {
            Utils::redirectTo('/');
        }
    }
}

if ($img == null || $img->user_id != Auth::user()->id) {
    Utils::redirectTo('/');
}

$imgPath = __DIR__.'/storage/'.$img->filename;

$mode = $_GET['mode'] ?? '';
$preview = $mode == 'preview';
$save = $mode == 'save';

$op = $_GET['op'] ?? '';
$level = max(-100, min(100, intval($_GET['level'] ?? 0)));

$canvas = Filters::apply($imgPath, $op, $level);
if ($preview) {
    echo $canvas->response('png');
    exit();
} elseif ($save) {
    $canvas->save();
    $op = '';
    $level = 0;
}

$deleteUrl = '/user.php?delete=1&img_id='.$img->id;
$editUrl = '/image.php?img_id='.$img->id;
$saveUrl = $editUrl.'&mode=save&op='.urlencode($op).'&level='.$level;
$previewUrl = $editUrl.'&mode=preview&op='.urlencode($op).'&level='.$level;
?>

<?php include __DIR__.'/fragments/header.php'; ?>

<div class="row">
    <div class="col s6">
        <img class="responsive-img" src="<?= htmlentities($previewUrl) ?>">
    </div>

    <div class="col s6">
        <div class="row">
            <a class="waves-effect waves-light btn" href="<?= htmlentities($deleteUrl) ?>">
                <i class="material-icons left">delete</i>
                Delete
            </a>
            <a class="waves-effect waves-light btn" href="<?= htmlentities($saveUrl) ?>">
                <i class="material-icons left">save</i>
                Save
            </a>
        </div>

        <div class="row">
            <a class="waves-effect waves-light btn" href="<?= htmlentities($editUrl.'&op=greyscale') ?>">Greyscale</a>
            <a class="waves-effect waves-light btn" href="<?= htmlentities($editUrl.'&op=sepia') ?>">Sepia</a>
        </div>

        <div class="row">
            <a class="waves-effect waves-light btn" href="<?= htmlentities($editUrl.'&op=gauss') ?>">Blur</a>
            <a class="waves-effect waves-light btn" href="<?= htmlentities($editUrl.'&op=edge') ?>">Edge Detection</a>
        </div>

        <div class="row">
            <a class="waves-effect waves-light btn" href="<?= htmlentities($editUrl.'&op=pixelate') ?>">Pixelate</a>
            <a class="waves-effect waves-light btn" href="<?= htmlentities($editUrl.'&op=invert') ?>">Invert</a>
        </div>

        <div class="row">
            <div class="row">
                <div class="col s6"><h5>Contrast</h5></div>
                <div class="col s6">
                    <a class="waves-effect waves-light btn"
                        href="<?= htmlentities($editUrl.'&op=contrast&level='.($level+10)) ?>">+</a>
                    <a class="waves-effect waves-light btn"
                        href="<?= htmlentities($editUrl.'&op=contrast&level='.($level-10)) ?>">-</a>
                </div>
            </div>

            <div class="row">
                <div class="col s6"><h5>Brightness</h5></div>
                <div class="col s6">
                    <a class="waves-effect waves-light btn"
                        href="<?= htmlentities($editUrl.'&op=brightness&level='.($level+10)) ?>">+</a>
                    <a class="waves-effect waves-light btn"
                        href="<?= htmlentities($editUrl.'&op=brightness&level='.($level-10)) ?>">-</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__.'/fragments/footer.php'; ?>