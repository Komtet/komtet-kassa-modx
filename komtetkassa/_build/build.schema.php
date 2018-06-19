<?php

require_once dirname(__FILE__).'/build.config.php';
include_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);

echo '<pre>'; /* used for nice formatting of log messages */

$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'model' => $root . 'core/components/' . PKG_NAME_LOWER . '/model/',
    'schema' => $root.'_build/schema/komtetkassa.mysql.schema.xml',
);

$manager= $modx->getManager();
$generator= $manager->getGenerator();

if (!is_dir($sources['model'])){
	$modx->log(modX::LOG_LEVEL_ERROR,'Model directory not found!');
	die();
}
if (!file_exists($sources['schema'])) {
	$modx->log(modX::LOG_LEVEL_ERROR,'Schema file not found!');
	die();
}

$generator->parseSchema($sources['schema'], $sources['model']);

echo 'DB schema created.';
exit();