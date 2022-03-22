<?php
namespace  ISN\CheckBox\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Grid  extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sales_order_grid','entity_id');
    }
}