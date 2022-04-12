<?php
namespace ISN\FormGrid\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
  
class Custom extends AbstractDb
{
   protected function _construct()
   {
        $this->_init('form_grid_table', 'id');
  
   }
  
}