<?php
// Thanks to Cygnix
// Created by Lemmmy

// 防止 ImageMagick 输出 deprecated 警告
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

require_once("p/.priv.php");

function autoload($class_name) {
	$directory = 'class/';

	if (file_exists($directory . $class_name . '.php')) {
		require_once ($directory . $class_name . '.php');
		return;
	}
}

// PHP 7.2 起需要使用这种方式，而不是 __autoload
spl_autoload_register('autoload');

$api = new OsuAPI(constant("AKEY"));

$user = $api->getUserForMode($_GET['uname'], isset($_GET['mode']) ? $_GET['mode'] : 0);

if (!$user) {
	$errorImage = new ErrorImage();
	$errorImage->generate("User not found", "The user you tried to generate \na signature for was not found.");
}

$colour = isset($_GET['colour']) && !empty($_GET['colour']) ? $_GET['colour'] : 'pink';

$sig = new OsuSignature($user, 'TemplateNormal');
$sig->generate(PredefinedColours::getPredefinedColour($colour));