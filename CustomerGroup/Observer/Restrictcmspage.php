<?php
namespace ISN\CustomerGroup\Observer;
 
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Store\Model\StoreManagerInterface; 
use Psr\Log\LoggerInterface ;

class Restrictcmspage implements ObserverInterface
{
    protected $_actionFlag;
    protected $responseFactory;
    protected $url;
     /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeInfo;

    /**
     * @var \ISN\CustomerGroup\Helper\Myhelper
     */
    protected $helper;
    public function __construct(
        CustomerSession $customerSession,
        \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Store\Model\StoreManagerInterface $storeInfo,
        \ISN\CustomerGroup\Helper\Myhelper $helper
        )
    {
        $this->customerSession = $customerSession;
        $this->_actionFlag = $actionFlag;
        $this->redirect = $redirect;
        $this->responseFactory = $responseFactory;
        $this->url = $url;
        $this->helper=$helper;
        $this->storeInfo=$storeInfo;
    }
    public function execute(Observer $observer)
    {
        $StoreId=$this->storeInfo->getStore()->getStoreId();
        $HomePageUrl=$this->storeInfo->getStore()->getBaseUrl();
    
       /** @var \Magento\Customer\Controller\Account\LoginPost\Interceptor $controller_action */
    $controller_action = $observer->getData( 'controller_action' );
    $parameters = $controller_action->getRequest()->getParams();
    $session = $this->customerSession;

    if($StoreId==2){
        $CustomerGroup = $this->helper->getGroupId();//get group code from helper class
            
            if($CustomerGroup=="Wholesale")//For Wholesaler //restriction
            {


                // setting an action flag to stop processing further hierarchy
                $this->_actionFlag->set('', \Magento\Framework\App\Action\Action::FLAG_NO_DISPATCH, true);



                /// redirecting back to its referred url
                $observer->getControllerAction()->getResponse()->setRedirect( $HomePageUrl);
                $session->setCustomerFormData($parameters);

            }
           
}


    return $this;
}
}




/* https://magento.stackexchange.com/questions/112993/magento2-redirection-from-observer */