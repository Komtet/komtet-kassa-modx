<?php

$menus = array();

$tmp = array(
    'komtetkassa' => array(
        'description' => 'Отчеты о фискализации оплат сервисом КОМТЕТ Касса',
        'action' => 'mgr/orderstatus',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modMenu $menu */
    $menu = $modx->newObject('modMenu');
    $menu->fromArray(array_merge(array(
        'text' => $k,
        'parent' => 'components',
        'namespace' => PKG_NAME_LOWER,
        'icon' => '',
        'menuindex' => 0,
        'params' => '',
        'handler' => '',
    ), $v), '', true, true);
    $menus[] = $menu;
}

unset($menu, $i);

return $menus;