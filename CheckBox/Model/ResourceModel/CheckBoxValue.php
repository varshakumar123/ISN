<?php
namespace  ISN\CheckBox\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CheckBoxValue  extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('quote','entity_id');
    }
}