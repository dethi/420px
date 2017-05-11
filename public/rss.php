<?php
require(__DIR__.'/../app/Bootstrap.php');

use App\Auth;
use App\Utils;
use App\Models\User;
use App\Models\Image;

$user = null;
if (!empty($_GET['id'])) {
    try {
        $user = User::find($_GET['id']);
    } catch (PDOException $e) {
        Utils::redirectTo('/');
    }
}

if ($user == null && Auth::check()) {
    $user = Auth::user();
} elseif ($user == null) {
    Utils::redirectTo('/');
}

try {
    $images = Image::findByUser($user->id);
} catch (PDOException $e) {
    $error = 'An error occured';
}

$hostname = $_SERVER['HTTP_HOST'];

header('Content-Type: application/xml; charset=utf-8');
?>
<?= '<?xml version="1.0" encoding="utf-8"?>' ?>
<rss version="2.0">
    <channel>
        <title>420px - <?= $user->name ?></title>
        <link><?= 'http://'.$hostname.'/user.php?id='.$user->id ?></link>
        <description>Profile of <?= $user->name ?></description>
    </channel>

    <?php foreach ($images as $img) : ?>
        <item>
            <link><?= 'http://'.$hostname.'/storage/'.$img->filename ?></link>
        </item>
    <?php endforeach; ?>
</rss>