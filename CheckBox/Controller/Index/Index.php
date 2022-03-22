<?php
namespace ISN\CheckBox\Controller\Index;

use Psr\Log\LoggerInterface ;
use Magento\Framework\App\Filesystem\DirectoryList;
use ISN\CheckBox\Model\CheckBoxValueFactory;
use ISN\CheckBox\Model\GridFactory;
use Magento\Checkout\Model\Session as CheckoutSession;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultjsonFactory;
    private $logger;
    protected $orderResourceModel;
protected $orderRepository;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    /**
     * @var Tychons\SecondTask\Model\ProductFactory;
     */
    protected $checkboxvalueFactory;
    protected $gridFactory;
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;
    private $cookieManager;
    private $filter;
    private $request;
    /**
    * Constructor
    *
    * @param \Magento\Framework\App\Action\Context $context
    * @param \Magento\Framework\Controller\Result\JsonFactory $resultjsonFactory,
    * @param \Magento\Framework\View\Result\PageFactory $pageFactory
    */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultjsonFactory,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        checkboxvalueFactory $checkboxvalueFactory,
        GridFactory $gridFactory,
         \Psr\Log\LoggerInterface $logger,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        CheckoutSession $checkoutSession,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Sales\Model\ResourceModel\Order $orderResourceModel
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->cookieManager = $cookieManager;
        $this->checkboxvalueFactory = $checkboxvalueFactory;
        $this->gridFactory = $gridFactory;
        $this->resultjsonFactory = $resultjsonFactory;  
         $this->logger = $logger;
        $this->filter            = $filter;
        $this->quoteRepository = $quoteRepository;
        $this->request=$request;
        $this->checkoutSession = $checkoutSession;
        $this->orderResourceModel = $orderResourceModel;
        $this->orderRepository = $orderRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        if (isset($_COOKIE['CheckBox']))
        {   
            $cookie= $this->cookieManager->getCookie('CheckBox');
            $cookievalue= $this->cookieManager->getCookie('CheckBoxValues');
            $this->logger->debug('cookie fine..'.$cookievalue);
            if($cookie=='true'){

                $order = $this->checkoutSession->getLastRealOrder();
                $orderId=$order->getEntityId();
                $a=$order->getIncrementId();
                echo  $b=$a+1 .'<br>';
               // echo  $c="0000000".$b .'<br>';
                echo  $a."<br>";
                echo $oid=$orderId+1 ."<br>";
                $quoteId=$this->checkoutSession->getQuote()->getId();
                echo $quoteId."<br>"; 
                $quote = $this->quoteRepository->get($quoteId); 
                $quote->setData('checkBoxValue', 1); 
                $this->quoteRepository->save($quote); 

                $name=$this->gridFactory->create();
                $studentobj=$name->load($a);
                $msgg='Checked';
                $studentobj->setMagenestcustomcolumn($msgg);
                $studentobj->save();
                $this->logger->debug('workingdf..'.$orderId);

               
            }
            else{
                $order = $this->checkoutSession->getLastRealOrder();
                $orderId=$order->getEntityId();
                $a=$order->getIncrementId();
                echo $a.'<br>';

                echo $oid=$orderId+1;
                $quoteId=$this->checkoutSession->getQuote()->getId();
                echo $quoteId; 
                $quote = $this->quoteRepository->get($quoteId);
                $quote->setData('checkBoxValue',0); 
                $this->quoteRepository->save($quote);

        
                $name=$this->gridFactory->create();

                $studentobj=$name->load($a);
                $msg='UnChecked';
                $studentobj->setMagenestcustomcolumn($msg);
                $studentobj->save();
                $this->logger->debug('workdd..'.$msg);
 
            } 
        }
       
     }
}