<?php

class KomtetKassaOrderStatusGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'komtetOrderFiscStatus';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'DESC';

    protected $query;


    public function initialize()
    {
        $this->modx->addPackage('komtetKassa', MODX_CORE_PATH . 'components/komtetkassa/model/');
        return parent::initialize();
    }


    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $this->query = $c;

        $c->select($this->modx->getSelectColumns('komtetOrderFiscStatus', 'komtetOrderFiscStatus', '', array('minishop_order_id', 'fisc_status'), true) . ',
            komtetOrderFiscStatus.minishop_order_id as minishop_order_id, komtetOrderFiscStatus.fisc_status as fisc_status');

        return $c;
    }


    public function getData()
    {
        $data = array();
        $limit = intval($this->getProperty('limit'));
        $start = intval($this->getProperty('start'));

        $c = $this->modx->newQuery($this->classKey);
        $c = $this->prepareQueryBeforeCount($c);
        $data['total'] = $this->modx->getCount($this->classKey, $c);
        $c = $this->prepareQueryAfterCount($c);

        $sortClassKey = $this->getSortClassKey();
        $sortKey = $this->modx->getSelectColumns($sortClassKey, $this->getProperty('sortAlias', $sortClassKey), '',
            array($this->getProperty('sort')));
        if (empty($sortKey)) {
            $sortKey = $this->getProperty('sort');
        }
        $c->sortby($sortKey, $this->getProperty('dir'));
        if ($limit > 0) {
            $c->limit($limit, $start);
        }

        if ($c->prepare() && $c->stmt->execute()) {
            $data['results'] = $c->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }


    public function iterate(array $data)
    {
        $list = array();
        $list = $this->beforeIteration($list);
        $this->currentIndex = 0;
        /** @var xPDOObject|modAccessibleObject $object */

        foreach ($data['results'] as $array) {
            $list[] = $this->prepareArray($array);
            $this->currentIndex++;
        }
        $list = $this->afterIteration($list);

        return $list;
    }


    public function prepareArray(array $data)
    {

        $data['actions'] = array(
        );

        return $data;
    }


    public function outputArray(array $array, $count = false)
    {
        if ($count === false) {
            $count = count($array);
        }

        $data = array(
            'success' => true,
            'results' => $array,
            'total' => $count,
        );

        return json_encode($data);
    }

}

return 'KomtetKassaOrderStatusGetListProcessor';
