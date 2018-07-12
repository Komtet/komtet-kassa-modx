<?php
switch ($modx->event->name) {

    case 'OnLoadWebDocument':
        // Handle non-ajax requests
        if (!empty($_REQUEST['kk_action'])) {
            if ($komtetKassa = $modx->getService('komtetKassa')) {
                $komtetKassa->handleRequest($_REQUEST['kk_action'], @$_POST);
            }
        }
        break;

    case 'msOnChangeOrderStatus':
        $modx->addPackage('komtetKassa', MODX_CORE_PATH . 'components/komtetkassa/model/');

        $komtetKassaFiscalizer = $modx->getService('komtetKassa', 'komtetKassaFiscalizer', MODX_CORE_PATH . 'components/komtetkassa/model/');

        // заказ имеет статус "оплачен"
        if ($status == 2) {

            $payment = $order->getOne('Payment');
            // заказ оплачен одним из способов оплаты
            if($payment && $payment->get('class')) {
                $orderId = $order->get('id');
                $existingOrderStatus = $modx->getObject('komtetOrderFiscStatus', array('minishop_order_id'=>$orderId));

                // если заказ не уходил на фискализацию или это возврат
                if ($existingOrderStatus === null || $order->get('type') == 1){
                    $komtetKassaFiscalizer->fiscalize($order);

                    $orderStatus = $modx->newObject('komtetOrderFiscStatus', array('minishop_order_id' => $orderId,
                                                                                   'fisc_status' => 'pending'));
                    $orderStatus->save();
                }
            }
        }
        break;

    case 'OnHandleRequest':
        $modx->addPackage('komtetKassa', MODX_CORE_PATH . 'components/komtetkassa/model/');

        if ($_SERVER['REQUEST_URI'] == '/komtet-kassa-report' && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $modx->exec("UPDATE `modx_komtet_order_fisc_status` SET `fisc_status` = '".$_POST['state']."' WHERE `modx_komtet_order_fisc_status`.`minishop_order_id` = ".$_POST['external_id']);
        }

        // Обработка ajax запросов к компоненту
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        if (empty($_REQUEST['kk_action']) || !$isAjax) {
            return;
        }
        if ($komtetKassa = $modx->getService('komtetKassa')) {
            $response = $komtetKassa->handleRequest($_REQUEST['kk_action'], @$_POST);
            @session_write_close();
            exit($response);
        }

        break;
}