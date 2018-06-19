<?php

if (!isset($modx)) {
    define('MODX_API_MODE', true);
    require dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

    $modx->getService('error', 'error.modError');
}

$modx->error->message = null;
/** @var miniShop2 $miniShop2 */
$miniShop2 = $modx->getService('miniShop2');

/** @var msOrder $order */
$order = $modx->newObject('msOrder');
/** @var msPaymentInterface|PaymentSender $handler */
