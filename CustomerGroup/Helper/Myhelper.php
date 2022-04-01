<?php
namespace ISN\CustomerGroup\Helper;

class Myhelper extends \Magento\Framework\View\Element\Template
{
    protected $_customerSession;
    protected $_customerGroupCollection;
    protected $custgrpcode;
    protected $CustomerCode;
    public function __construct(
               
            \Magento\Customer\Model\Session $customerSession,
            \Magento\Customer\Model\Group $customerGroupCollection
    
        ) {
    
    
            $this->_customerSession = $customerSession;
            $this->_customerGroupCollection = $customerGroupCollection;
    
        }
    
    public function getGroupId($custgrpcode=null){
        
     if($this->_customerSession->isLoggedIn()){
         $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();
         $groupCollection = $this->_customerGroupCollection->load($customerGroupId);
         $custgrpcode=$groupCollection->getCustomerGroupCode();//Get current customer group name
        
        }
        return $custgrpcode;
    }
}
