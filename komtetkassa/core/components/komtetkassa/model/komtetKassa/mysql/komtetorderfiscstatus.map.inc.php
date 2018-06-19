<?php
$xpdo_meta_map['komtetOrderFiscStatus']= array (
  'package' => 'komtetKassa',
  'version' => NULL,
  'table' => 'komtet_order_fisc_status',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'MyISAM',
  ),
  'fields' => 
  array (
    'minishop_order_id' => 0,
    'fisc_status' => '',
  ),
  'fieldMeta' => 
  array (
    'minishop_order_id' => 
    array (
      'dbtype' => 'integer',
      'precision' => '100',
      'phptype' => 'int',
      'null' => false,
      'default' => 0,
    ),
    'fisc_status' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
  ),
);
