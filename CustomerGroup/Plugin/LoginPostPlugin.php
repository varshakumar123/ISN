<?php
namespace ISN\CustomerGroup\Plugin;

use Psr\Log\LoggerInterface ;
use Magento\Store\Model\StoreManagerInterface;
/**
 * Restrict Site Access Base On Customer Group
 */
class LoginPostPlugin
{
    /**
     * @var \Psr\Log\LoggerInterface 
     */
    private $logger;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeInfo;

    /**
     * @var \ISN\CustomerGroup\Helper\Myhelper
     */
    protected $helper;

    /**
     * @param LoggerInterface $logger
     * @param StoreManagerInterface $storeInfo
     * @param Myhelper $helper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Store\Model\StoreManagerInterface $storeInfo,
        \ISN\CustomerGroup\Helper\Myhelper $helper
	)
	{
        $this->logger = $logger; 
        $this->helper=$helper;
        $this->storeInfo=$storeInfo;
	}
  
    /**
     * Change redirect after login to home instead of dashboard.
     *
     * @param \Magento\Customer\Controller\Account $subject
     * @param \Magento\Framework\Controller\Result\Redirect $result
     */
    public function afterExecute(\Magento\Customer\Controller\Account\LoginPost $subject,$result)
    {  
        $StoreId=$this->storeInfo->getStore()->getStoreId();
        $HomePageUrl=$this->storeInfo->getStore()->getBaseUrl();
    
        if($StoreId==2 )//For MyStore site
        {
            $CustomerGroup = $this->helper->getGroupId();//get group code from helper class
            
            if($CustomerGroup=="Wholesale")//For Wholesaler //restriction
            {
                $result->setPath($HomePageUrl); // Redirect to home page after login to restrict access
                return $result;
            }
            if($CustomerGroup=="General")//For General
            {
                return $result;
            }
            if($CustomerGroup=="Retailer")//For Retailer
            {
                return $result;
            }
        } 
        else{
            return $result;
        } 
    }
}
       
                
        
 
        


        
        
    
