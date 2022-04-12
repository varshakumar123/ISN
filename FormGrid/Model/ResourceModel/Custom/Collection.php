<?php
namespace ISN\FormGrid\Model\ResourceModel\Custom;
 
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
 
class Collection extends AbstractCollection
 
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        $this->_init('ISN\FormGrid\Model\Custom','ISN\FormGrid\Model\ResourceModel\Custom');
 
    }
 
}