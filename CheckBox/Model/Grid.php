<?php
namespace  ISN\CheckBox\Model;

use Magento\Framework\Model\AbstractModel;
use ISN\CheckBox\Model\ResourceModel\Grid as GridResourceModel;

class Grid extends AbstractModel
{   protected function _construct()
    {
        $this->_init(GridResourceModel::class);
    }
}