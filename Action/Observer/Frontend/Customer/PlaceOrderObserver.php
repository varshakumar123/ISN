<?php
namespace ISN\Action\Observer\Frontend\Customer;

use Psr\Log\LoggerInterface ;
use Magento\Framework\Event\ObserverInterface;
use ISN\Action\Model\CustomerActionFactory;

class PlaceOrderObserver implements \Magento\Framework\Event\ObserverInterface
{
    protected $customeractionFactory;
    private $logger;
    public function __construct(
        \Psr\Log\LoggerInterface $logger,CustomerActionFactory $customeractionFactory)
	{
		$this->logger = $logger;  
        $this->customeractionFactory = $customeractionFactory;
	}
    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer) 
    {
   

    /*  To get Current Date and Time */   
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
    $date = $objDate->gmtDate();
   
    /*  To get Customer Info */
    $om = \Magento\Framework\App\ObjectManager::getInstance();  
    $customerSession = $om->get('Magento\Customer\Model\Session');  
    $customerDataName = $customerSession->getCustomer()->getName();

    /*Add a new row in table */
    $db=$this->customeractionFactory->create();
    
    $db->addData(['cust_name'=>$customerDataName,'cust_action'=>'Place Order','c_time'=>$date]);
    $db->save();
    $this->logger->debug('place order event working fine..');
    
    }
}