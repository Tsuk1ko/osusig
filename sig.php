<?php
require_once('p/.priv.php');

error_reporting(E_ERROR | E_PARSE);

$mc = new Memcached();
$mc->addServer("localhost", 11211);

$apiURL = 'https://osu.ppy.sh/api/';

$templateDirectory = 'templates/';
$flagsDirectory = 'flags/';
$modesDirectory = 'modes/';
$fontDirectory = 'fonts/';

$fontRegular = $fontDirectory . 'exo2regular.ttf';
$fontMedium = $fontDirectory . 'exo2medium.ttf';
$fontBold = $fontDirectory . 'exo2bold.ttf';
$fontIcons = $fontDirectory . 'osu!font.ttf';

if (!isset($_GET['colour']) || !isset($_GET['uname'])) {
    die();
}

$colour = strtolower($_GET['colour']);
$pp = $_GET['pp'];
$uname = urldecode($_GET['uname']);
$mode = isset($_GET['mode']) ? $_GET['mode'] : 0;
$modeName = 'osu';

switch ($mode) {
    case 0:
        $modeName = 'osu';
        break;
    case 1:
        $modeName = 'taiko';
        break;
    case 2:
        $modeName = 'ctb';
        break;
    case 3:
        $modeName = 'mania';
        break;
    default:
        $modeName = 'osu';
        break;
}

$userInfo = $mc->get("stats_" . strtolower($uname));

if (!$userInfo) {
    $userInfo = json_decode(file_get_contents($apiURL . 'get_user' . '?' .
                              'k'       . '=' . constant('AKEY') .
                              '&u'       . '=' . $uname .
                              '&m'       . '=' . $mode))[0];

    $mc->set("stats_" . strtolower($uname), $userInfo, 180);
}

function getFontSize ($size) {
    return ($size * 3) / 4;
}

$img = new Imagick($templateDirectory . $colour . '.png');
$draw = new ImagickDraw();

$textWhite = '#FFFFFF';
$textGrey = '#555555';

header('Content-Type: image/'.$img->getImageFormat());
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

// rank
$draw->setFont($fontRegular);
$draw->setFontSize(14);
$draw->setFillColor($textWhite);
$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);

$rankTextWidth = $img->queryFontMetrics($draw, '#' . number_format($userInfo->pp_rank))['textWidth'];
$img->annotateImage($draw, 287, 32, 0, '#' . number_format($userInfo->pp_rank));

// mode
$draw->setFont($fontIcons);
$draw->setFontSize(14);
$draw->setTextAlignment(\Imagick::ALIGN_LEFT);
$img->annotateImage($draw, 290, 31, 0, json_decode('"\\ue00' . $mode . '"'));

// flag
$flag = new Imagick($flagsDirectory . $userInfo->country . '.png');
$flag->resizeImage(18, 12, \Imagick::FILTER_CATROM, 1);

if (isset($_GET['flagshadow'])) {
    $shadow = $flag->clone();
    $shadow->setImageBackgroundColor(new ImagickPixel('black'));

    $shadow->shadowImage(50, 3, 0, 0);

    $img->compositeImage($shadow, \Imagick::COMPOSITE_DEFAULT, 301, 15);
}

if (isset($_GET['flagstroke'])) {
    $flagStroke = new \ImagickDraw();

    $flagStroke->setFillColor("#FFFFFF");
    $flagStroke->roundRectangle(306, 20, 306 + 19, 20 + 13, 1, 1);

    $img->drawImage($flagStroke);
}

$img->compositeImage($flag, \Imagick::COMPOSITE_DEFAULT, 307, 21);

// name
$nameFontSize = 24;
$draw->setFont($fontMedium);
$draw->setFontSize($nameFontSize);

$nameDimensions = imagettfbbox(getFontSize($nameFontSize), 0, $fontMedium, $userInfo->username);
$nameTextWidth = abs($nameDimensions[4] - $nameDimensions[0]);

while ($nameTextWidth > 198 - $rankTextWidth) {
    $nameDimensions = imagettfbbox(getFontSize($nameFontSize), 0, $fontMedium, $userInfo->username);
    $nameTextWidth = abs($nameDimensions[4] - $nameDimensions[0]);

    $nameFontSize -= 0.5;
}

$draw->setFontSize($nameFontSize);
$img->annotateImage($draw, 90, 32, 0, $userInfo->username);

$draw->setFont($fontRegular);

// pp

if (isset($_GET['pp']) && $pp == 2) {
    $draw->setFontSize(10);
    $draw->setTextAlignment(\Imagick::ALIGN_RIGHT);

    $ppText = number_format(floor($userInfo->pp_raw)) . 'pp';
    $img->annotateImage($draw, 326, 17, 0, $ppText);
}

// accuracy & play count

$draw->setFontSize(14);
$draw->setFillColor($textGrey);
$draw->setTextAlignment(\Imagick::ALIGN_LEFT);

$img->annotateImage($draw, 91, 56, 0, 'Accuracy');
$img->annotateImage($draw, 91, 73, 0, 'Play count');

$draw->setTextAlignment(\Imagick::ALIGN_RIGHT);

$draw->setFont($fontBold);

$accuracyText = isset($_GET['pp']) && $pp == 1 ? ' (' . number_format(floor($userInfo->pp_raw)) . 'pp)' : '';
$img->annotateImage($draw, 325, 56, 0, round($userInfo->accuracy, 2) . '%' . $accuracyText);

$levelText = isset($_GET['pp']) && $pp == 0 ? ' (' . number_format(floor($userInfo->pp_raw)) . 'pp)' : ' (lv' . floor($userInfo->level) . ')';
$img->annotateImage($draw, 325, 73, 0, number_format($userInfo->playcount) . $levelText);

// avatar
$avatarURL = 'https://a.ppy.sh/' . $userInfo->user_id . '?' . time() . '.png';
$avatar = new Imagick();
$cachedPicture = $mc->get("profilepicture_" . strtolower($uname));

if (!$cachedPicture) {
    $avatar = new Imagick($avatarURL);
    $avatar->setImageFormat('png');

    $mc->set("profilepicture_" . strtolower($uname), base64_encode($avatar->getImageBlob()), 43200);
} else {
    $decodedPicture = base64_decode($cachedPicture);
    $avatar->readImageBlob($decodedPicture);
    $avatar->setImageFormat('png');
}

$avatar->setImageMatte(1);

$avatarSize = isset($_GET['removeavmargin']) ? 80 : 76;
$avatarPos = isset($_GET['removeavmargin']) ? 7 : 9;

$maskImage = isset($_GET['removeavmargin']) ? "img/mask_80.png" : "img/mask_76.png";

$avatarClipMask = new Imagick($maskImage);

$avatar->resizeImage($avatarSize, $avatarSize, \Imagick::FILTER_CATROM, 1);
$avatar->compositeImage($avatarClipMask, \Imagick::COMPOSITE_DSTIN, 0, 0);

$img->compositeImage($avatar, \Imagick::COMPOSITE_DEFAULT, $avatarPos, $avatarPos);

echo $img;