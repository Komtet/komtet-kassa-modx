<?php
/** @var xPDOTransport $transport */
/** @var array $options */
if ($transport->xpdo) {
    /** @var modX $modx */
    $modx =& $transport->xpdo;

    /** @var miniShop2 $miniShop2 */
    if (!$miniShop2 = $modx->getService('miniShop2')) {
        $modx->log(modX::LOG_LEVEL_ERROR, 'komtetKassa Could not load miniShop2');

        return false;
    }
    if (!property_exists($miniShop2, 'version') || version_compare($miniShop2->version, '2.4.0-pl', '<')) {
        $modx->log(modX::LOG_LEVEL_ERROR,
            'komtetKassa You need to upgrade miniShop2 at least to version 2.4.0-pl');

        return false;
    }

}
return true;