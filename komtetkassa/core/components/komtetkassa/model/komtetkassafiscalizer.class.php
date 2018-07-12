<?php

use Komtet\KassaSdk\Check;
use Komtet\KassaSdk\Position;
use Komtet\KassaSdk\Vat;
use Komtet\KassaSdk\Client;
use Komtet\KassaSdk\QueueManager;
use Komtet\KassaSdk\Payment;

class komtetKassaFiscalizer
{
    /** @var modX $modx */
    public $modx;

    /**
     * @param modX $modx
     * @param array $config
     */
    function __construct(modX &$modx, array $config = array())
    {
        $this->modx =& $modx;
        $this->config = array_merge(array(
            'shop_id' => $this->modx->getOption('komtetkassa_shop_id'),
            'queue_id' => $this->modx->getOption('komtetkassa_queue_id'),
            'secret' => $this->modx->getOption('komtetkassa_secret'),
            'is_print_check' => $this->modx->getOption('komtetkassa_is_print_check', null, true),
            'sno' => $this->modx->getOption('komtetkassa_sno')
        ), $config);
    }


    public function fiscalize($order)
    {

        include_once dirname(dirname(__FILE__)) . '/sdk/Check.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/Client.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/Payment.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/Position.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/QueueManager.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/Vat.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/Exception/ClientException.php';
        include_once dirname(dirname(__FILE__)) . '/sdk/Exception/SdkException.php';

        $user = $order->getOne('UserProfile');

        // Параметры для фискализации берутся из настроек компонента
        $checkParams = array(
            'id' => (string)$order->get('id'),
            'shop_id' => $this->config['shop_id'],
            'queue_id' => $this->config['queue_id'],
            'secret' => $this->config['secret'],
            'is_print_check' => $this->config['is_print_check'],
            'sno' => $this->config['sno'],
        );

        // Создается способ оплаты чека
        $payment = Payment::createCard(floatval($order->get('cost')));

        // Создается чек

        $check_method = $order->get('type') == 1 ? Check::INTENT_SELL_RETURN : Check::INTENT_SELL;

        $check = new Check($checkParams['id'], $user->email, $check_method, intval($checkParams['sno']));
        $check->setShouldPrint($checkParams['is_print_check']);
        $check->addPayment($payment);

        // Достаются позиции из заказа
        $positions = $order->getMany('Products');

        $defaultVat = new Vat(Vat::RATE_NO);
        // Создаются позиции чека
        foreach($positions as $position) {
            $opts = $position->get('options');
            if (!$opts['vat']) {
                $vat = $defaultVat;
            }
            else {
                $vat = $opts['vat'];
            }

            $positionObj = new Position($position->name,
                                        floatval($position->price),
                                        floatval($position->count),
                                        $position->count*$position->price,
                                        floatval($position->order_discount),
                                        $vat);
            $check->addPosition($positionObj);
        }

        // Позиция стоимости доставки
        if (floatval($order->delivery_cost) > 0) {
            $shippingPosition = new Position("Доставка",
                                             floatval($order->delivery_cost),
                                             1,
                                             floatval($order->delivery_cost),
                                             0,
                                             new Vat(Vat::RATE_NO));
            $check->addPosition($shippingPosition);
        }

        // Создается клиент для подключения к комтет кассе
        $client = new Client($checkParams['shop_id'], $checkParams['secret']);

        // Создается менеджер очереди
        $queueManager = new QueueManager($client);
        $queueManager->registerQueue('print_que', $checkParams['queue_id']);

        // Отправка на фискализацию
        try {
            $queueManager->putCheck($check, 'print_que');
        } catch (SdkException $e) {
            $this->$modx->log(modX::ERROR, 'SdkException: '.$e->getMessage());
        }
    }
}