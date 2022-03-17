<?php
namespace  ISN\Action\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomerAction  extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('customer_action_time','cust_id');
    }
}