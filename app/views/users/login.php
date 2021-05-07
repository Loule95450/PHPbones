<?php
require APP_ROOT . '/views/inc/head.php';
?>
<div class="navbar dark">
    <?php
    require APP_ROOT . '/views/inc/nav.php';
    ?>
</div>

<div class="container-login">
    <div class="wrapper-login">
        <h2>Signin</h2>
        <form method="post" action="<?= URL_ROOT ?>/users/login">
            <input type="text" name="username" placeholder="Username">
            <span class="invalidFeedback">
                <?= $data['usernameError'] ?>
            </span>

            <input type="password" name="password" placeholder="Password">
            <span class="invalidFeedback">
                <?= $data['passwordError'] ?>
            </span>

            <button type="submit" id="submit" value="submit">Sign In</button>

            <p class="options">Not registered yet? <a href="<?= URL_ROOT ?>/users/register">Create an account</a></p>
        </form>
    </div>
</div>