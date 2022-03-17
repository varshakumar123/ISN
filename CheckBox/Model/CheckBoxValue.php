<?php
namespace  ISN\CheckBox\Model;

use Magento\Framework\Model\AbstractModel;
use ISN\CheckBox\Model\ResourceModel\CheckBoxValue as CheckBoxValueResourceModel;

class CheckBoxValue extends AbstractModel
{   protected function _construct()
    {
        $this->_init(CheckBoxValueResourceModel::class);
    }
}