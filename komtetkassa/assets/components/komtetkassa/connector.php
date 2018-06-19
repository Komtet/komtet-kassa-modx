<?php
/** @noinspection PhpIncludeInspection */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';

/** @var modX $modx */
/** @var miniShop2 $miniShop2 */
//$komtetKassa = $modx->getService('komtetKassa');

$modx->lexicon->load('minishop2:default', 'minishop2:manager');

$path = MODX_CORE_PATH . 'components/komtetkassa/processors/';
/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));