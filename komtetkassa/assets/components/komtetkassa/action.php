<?php

if (!empty($_REQUEST['action'])) {
    $_REQUEST['kk_action'] = $_REQUEST['action'];
}

/** @noinspection PhpIncludeInspection */
require dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';