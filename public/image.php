<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;
use App\Models\Image;
use Intervention\Image\ImageManagerStatic as ImageManager;

Utils::redirectIfGuest("/");

$img = null;
if (!empty($_GET['img_id'])) {
    try {
        $img = Image::find($_GET['img_id']);
    } catch (PDOException $e) {
        Utils::redirectTo('/');
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
$canvas = ImageManager::make($imgPath);

switch ($op) {
    case 'greyscale':
        $canvas->greyscale();
        break;
    case 'sepia':
        $canvas->greyscale();
        $canvas->colorize(25, 11, 0);
        break;
    case 'gauss':
        $canvas->blur();
        break;
    case 'edge':
        $ressource = $canvas->getCore();
        imagefilter($ressource, IMG_FILTER_EDGEDETECT);
        break;
    case 'pixelate':
        $canvas->pixelate(12);
        break;
    case 'invert':
        $canvas->invert();
        break;
    case 'contrast':
        $canvas->contrast($level);
        break;
    case 'brightness':
        $canvas->brightness($level);
        break;
    default:
        break;
}

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
$saveUrl = $editUrl.'&mode=save&op='.urlencode($op);
$previewUrl = $editUrl.'&mode=preview&op='.urlencode($op);
?>

<?php include __DIR__.'/fragments/header.php'; ?>
<h1>Image editing</h1>

<img src="<?php echo htmlentities($previewUrl) ?>">

<div>
    <a href="<?php echo htmlentities($deleteUrl) ?>">Delete</a>
    <a href="<?php echo htmlentities($saveUrl) ?>">Save</a>
</div>

<div>
    <a href="<?php echo htmlentities($editUrl.'&op=greyscale') ?>">Greyscale</a>
    <a href="<?php echo htmlentities($editUrl.'&op=sepia') ?>">Sepia</a>
    <a href="<?php echo htmlentities($editUrl.'&op=gauss') ?>">Blur</a>
    <a href="<?php echo htmlentities($editUrl.'&op=edge') ?>">Edge Detection</a>
    <a href="<?php echo htmlentities($editUrl.'&op=pixelate') ?>">Pixelate</a>
    <a href="<?php echo htmlentities($editUrl.'&op=invert') ?>">Invert</a>


    <p>Contrast:
        <a href="<?php echo htmlentities($editUrl.'&op=contrast&level='.($level+10)) ?>">+</a>
        <a href="<?php echo htmlentities($editUrl.'&op=contrast&level='.($level-10)) ?>">-</a>
    </p>

    <p>Brightness:
        <a href="<?php echo htmlentities($editUrl.'&op=brightness&level='.($level+10)) ?>">+</a>
        <a href="<?php echo htmlentities($editUrl.'&op=brightness&level='.($level-10)) ?>">-</a>
    </p>
</div>

<?php include __DIR__.'/fragments/footer.php'; ?>