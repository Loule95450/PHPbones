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
        <h1>Configure your project</h1>

        <form action="<?= URL_ROOT ?>" method="post">
            <input type="text" name="SITE_NAME" placeholder="Site Name">
            <input type="text" name="CARD_DESCRIPTION" placeholder="Short Description">
            <input type="text" name="DB_HOST" placeholder="DataBase Host">
            <input type="text" name="DB_USER" placeholder="DataBase User">
            <input type="password" name="DB_PASS" placeholder="DataBase Password">
            <input type="text" name="DB_NAME" placeholder="DataBase Name">
            <input type="submit">
        </form>
    </main>
    <?php
        require APP_ROOT . '/views/inc/footer.php';
    ?>
</body>
