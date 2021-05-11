<?php
file_put_contents('.htaccess', '<IfModule mod_rewrite.c>
    Options -Multiviews
    RewriteEngine On
    RewriteBase ' . str_replace("/index.php", "", $_SERVER['SCRIPT_NAME']) . '
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule  ^(.+)$ index.php?url=$1 [QSA,L]
</IfModule>');

require_once '../app/require.php';