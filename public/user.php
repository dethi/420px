<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;
use App\Models\User;
use App\Models\Image;

$user = null;
if (!empty($_GET['id'])) {
    $userId = $_GET['id'];
    if (filter_var($userId, FILTER_VALIDATE_INT)) {
        try {
            $user = User::find($userId);
        } catch (PDOException $e) {
            Utils::redirectTo('/');
        }
    } else {
        Utils::redirectTo('/');
    }
}

if ($user == null && Auth::check()) {
    $user = Auth::user();
} elseif ($user == null) {
    Utils::redirectTo('/');
}
$isOwner = ($user == Auth::user());

if ($isOwner && !empty($_GET['delete']) && !empty($_GET['img_id'])) {
    $img = Image::find($_GET['img_id']);
    if ($img != null && $img->user_id == $user->id) {
        $img->delete();
        unlink(__DIR__.'/storage/'.$img->filename);
    }
}

try {
    $images = Image::findByUser($user->id);
} catch (PDOException $e) {
    $error = 'An error occured';
}
?>

<?php include __DIR__.'/fragments/header.php'; ?>
<div class="row">
    <div class="col s6">
        <h2><?= $user->name ?></h2>
    </div>
    <div class="col s6">
        <a class="waves-effect waves-light btn" href="<?= '/rss.php?id='.$user->id ?>">
            <i class="material-icons">rss_feed</i>
        </a>
    </div>
</div>

<div>
    <?php foreach ($images as $img) : ?>
        <div class="row">
            <div class="col s6">
                <img class="responsive-img" src="/storage/<?= $img->filename ?>">
            </div>

            <div class="col s6">
                <?php
                if ($isOwner) {
                    $deleteUrl = '/user.php?delete=1&img_id='.$img->id;
                    echo '<div class="row"><a class="waves-effect waves-light btn" href="'.htmlentities($deleteUrl).'"><i class="material-icons left">delete</i> Delete</a></div>';

                    $editUrl = '/image.php?img_id='.$img->id;
                    echo '<div class="row"><a class="waves-effect waves-light btn" href="'.htmlentities($editUrl).'"><i class="material-icons left">mode_edit</i>Edit</a></div>';
                }
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include __DIR__.'/fragments/footer.php'; ?>