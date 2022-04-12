<?php
namespace ISN\FormGrid\Model;
 
use Magento\Framework\Model\AbstractModel;
 
class Custom extends AbstractModel 
{
    const CACHE_TAG = 'id';
    protected function _construct()
    {
        $this->_init('ISN\FormGrid\Model\ResourceModel\Custom');
    }
  
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
 
    }
 
}