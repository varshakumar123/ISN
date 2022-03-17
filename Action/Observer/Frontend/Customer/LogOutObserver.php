<?php
namespace ISN\Action\Observer\Frontend\Customer;
use Psr\Log\LoggerInterface ;
use Magento\Framework\Event\ObserverInterface;
use ISN\Action\Model\CustomerActionFactory;
class LogOutObserver implements \Magento\Framework\Event\ObserverInterface
{protected $customeractionFactory;
    private $logger;
    public function __construct(
        \Psr\Log\LoggerInterface $logger,CustomerActionFactory $customeractionFactory
	)
	{
	
		$this->logger = $logger;  $this->customeractionFactory = $customeractionFactory;
	}
    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(
        \Magento\Framework\Event\Observer $observer
    ) {
        //Here you can get your customer data by following
         // echo $customerGroup=$this->_customerSession->getCustomer()->getGroupId();

    $customer = $observer->getEvent()->getCustomer();
    $name= $customer->getName(); //Get customer name
    echo $customer->getGroupId(); //Get customer group and place your Logic here what you want to Do.
    echo "<script>javascript: alert('test msgbox')></script>";
    echo "Testing";
    $this->logger->debug('event working fine..');
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $objDate = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
    $date = $objDate->gmtDate();
    //display the converted time
    $updateddate=date('Y-m-d H:i',strtotime('+5 hour +30 minutes',strtotime($date)));
    echo "crt date".$updateddate;
    $this->logger->debug('event working fine..'.$date);
    $db=$this->customeractionFactory->create();
    /**
    *
    * Add a new row in table
    * 
    */
    $db->addData(['cust_name'=>$name,'cust_action'=>'Logout','c_time'=>$date]);
    $db->save();
    
    }
}