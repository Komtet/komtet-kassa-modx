<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'shop_id' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'komtetkassa_main',
    ),
    'queue_id' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'komtetkassa_main',
    ),
    'secret' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'komtetkassa_main',
    ),
    'is_print_check' => array(
        'xtype' => 'combo-boolean',
        'value' => true,
        'area' => 'komtetkassa_main',
    ),
    'sno' => array(
        'xtype' => 'textfield',
        'value' => true,
        'area' => 'komtetkassa_main',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'komtetkassa_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
