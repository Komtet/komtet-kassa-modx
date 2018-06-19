<?php

if (!class_exists('kkManagerController')) {
    require_once dirname(dirname(__FILE__)) . '/manager.class.php';
}

class KomtetKassaMgrOrderStatusManagerController extends kkManagerController {

    // public $k;

    public function getPageTitle()
    {
        return "Статусы фискализации заказов";
    }

    public function getLanguageTopics()
    {
        return array('komtetKassa:default', 'komtetKassa:product', 'komtetKassa:manager');
    }

    public function loadCustomCssJs()
    {

        $corePath = $this->modx->getOption('komtetkassa.core_path', $config, MODX_CORE_PATH . 'components/komtetkassa/');
        $assetsPath = $this->modx->getOption('komtetkassa.assets_path', $config,
            MODX_ASSETS_PATH . 'components/komtetkassa/'
        );
        $assetsUrl = $this->modx->getOption('komtetkassa.assets_url', $config, MODX_ASSETS_URL . 'components/komtetkassa/');
        $actionUrl = $this->modx->getOption('komtetkassa.action_url', $config, $assetsUrl . 'action.php');
        $connectorUrl = $assetsUrl . 'connector.php';

        $config = array(
            'corePath' => $corePath,
            'assetsPath' => $assetsPath,
            'modelPath' => $corePath . 'model/',
            'customPath' => $corePath . 'custom/',
            'pluginsPath' => $corePath . 'plugins/',
            'connectorUrl' => $connectorUrl,
            'connector_url' => $connectorUrl,
            'assetsUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl . 'css/',
            'jsUrl' => $assetsUrl . 'js/',
            'actionUrl' => $actionUrl,

            'defaultThumb' => $this->modx->getOption('ms2_product_thumbnail_default', $config,
                $assetsUrl . 'img/mgr/ms2_thumb.png'
            ),
            'ctx' => 'web',
            'json_response' => false,
        );

        $this->addCss($config['cssUrl'] . 'mgr/bootstrap.buttons.css');
        $this->addCss($config['cssUrl'] . 'mgr/main.css');
        $this->addJavascript($config['jsUrl'] . 'mgr/komtetkassa.js');
        $this->addJavascript($config['jsUrl'] . 'mgr/misc/default.grid.js');
        $this->addJavascript($config['jsUrl'] . 'mgr/misc/default.window.js');
        $this->addJavascript($config['jsUrl'] . 'mgr/misc/ms2.utils.js');
        $this->addJavascript($config['jsUrl'] . 'mgr/misc/ms2.combo.js');

        $this->addJavascript($config['jsUrl'] . 'mgr/orders/orders.grid.js');
        $this->addJavascript($config['jsUrl'] . 'mgr/orders/orders.panel.js');

        $this->addJavascript(MODX_MANAGER_URL . 'assets/modext/util/datetime.js');

        $config['order_grid_fields'] = array('minishop_order_id', 'fisc_status');;

        $this->addHtml('
            <script type="text/javascript">
                miniShop2.config = ' . json_encode($config) . ';
                Ext.onReady(function() {
                    MODx.add({xtype: "komtet-order-status-panel"});
                });
            </script>'
        );

        $this->modx->invokeEvent('msOnManagerCustomCssJs', array(
            'controller' => &$this,
            'page' => 'orders',
        ));
    }

    /**
     * @param string $script
     */
    public function addCss($script)
    {
        $script = $script . '?v=';
        parent::addCss($script);
    }


    /**
     * @param string $script
     */
    public function addJavascript($script)
    {
        $script = $script . '?v=';
        parent::addJavascript($script);
    }


    /**
     * @param string $script
     */
    public function addLastJavascript($script)
    {
        $script = $script . '?v=';
        parent::addLastJavascript($script);
    }

}