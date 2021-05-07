<?php
	require APP_ROOT . '/views/inc/head.php';
?>
<body>
    <?php
        require APP_ROOT . '/views/inc/nav.php';
    ?>

    <header>
        <h1><?= $data['title'] ?></h1>
        <h1>Welcome to <?= SITE_NAME ?></h1>
    </header>

    <main>
        <iframe src="https://hackmd.io/@OJ4eGhBMSO2CcNq6fuEz9g/rJsVIgXOO"></iframe>
    </main>

    <?php
        require APP_ROOT . '/views/inc/footer.php';
    ?>
</body>
