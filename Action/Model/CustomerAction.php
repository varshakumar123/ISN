<?php
namespace  ISN\Action\Model;

use Magento\Framework\Model\AbstractModel;
use ISN\Action\Model\ResourceModel\CustomerAction as CustomerActionResourceModel;

class CustomerAction extends AbstractModel
{   protected function _construct()
    {
        $this->_init(CustomerActionResourceModel::class);
    }
}