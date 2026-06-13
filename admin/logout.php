<?php
if (!is_dir('/tmp/kfi_sessions')) {
    mkdir('/tmp/kfi_sessions', 0775, true);
}
session_save_path('/tmp/kfi_sessions');
session_start();
$_SESSION = [];
session_destroy();
header('Location: login.php');
exit;
