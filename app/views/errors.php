<?php
	/* Including the head.php file in the views/inc folder. */
	require APP_ROOT . '/views/inc/head.php';
?>
<body>
    <main>
        <h1>Something has gone wrong | <?= $data['errorCode'] ?></h1>
    </main>
</body>
