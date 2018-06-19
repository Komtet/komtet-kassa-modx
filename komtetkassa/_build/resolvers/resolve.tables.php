<?php
if ($object->xpdo) {
    $modx =& $object->xpdo;

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
    
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:

            $created = $modx->query("CREATE TABLE IF NOT EXISTS ".$modx->getOption('table_prefix')."komtet_order_fisc_status (
                id int NOT NULL AUTO_INCREMENT,
                minishop_order_id int,
                fisc_status varchar(255),
                PRIMARY KEY (id)
            )");
 
            break;
        case xPDOTransport::ACTION_UPGRADE:
            break;
        case xPDOTransport::ACTION_UNINSTALL:
            $deleted = $modx->query("DROP TABLE IF EXISTS ".$modx->getOption('table_prefix')."komtet_order_fisc_status");
            break;
    }
}
return true;