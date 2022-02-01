<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta htttp-equiv="Cache-control" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <meta name="title" content="<?= SITE_NAME ?>">
    <meta name="description" content="<?= CARD_DESCRIPTION ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= URL_ROOT ?>">
    <meta property="og:title" content="<?= SITE_NAME ?>">
    <meta property="og:description" content="<?= CARD_DESCRIPTION ?>">
    <meta property="og:image" content="<?= CARD_IMAGE ?>">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?= URL_ROOT ?>">
    <meta property="twitter:title" content="<?= SITE_NAME ?>">
    <meta property="twitter:description" content="<?= CARD_DESCRIPTION ?>">
    <meta property="twitter:image" content="<?= CARD_IMAGE ?>">

    <!-- TabName -->
    <title><?= isset($data['headTitle']) ? $data["headTitle"] . " - " .  SITE_NAME : SITE_NAME ?></title>

    <!-- Styles -->
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/css/normalize.css">
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/css/global.style.css">
    <?php if(isset($data['cssFile'])): ?><link rel="stylesheet" href="<?= URL_ROOT ?>/public/css/<?= $data['cssFile'] ?>.style.css"><?php endif; ?>

    <!-- Load FontAwsome and Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>

