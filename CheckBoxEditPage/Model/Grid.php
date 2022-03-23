<?php
namespace  ISN\CheckBoxEditPage\Model;

use Magento\Framework\Model\AbstractModel;
use ISN\CheckBoxEditPage\Model\ResourceModel\Grid as GridResourceModel;

class Grid extends AbstractModel
{   protected function _construct()
    {
        $this->_init(GridResourceModel::class);
    }
}