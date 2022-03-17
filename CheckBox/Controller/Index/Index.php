<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ISN\CheckBox\Controller\Index;
use Psr\Log\LoggerInterface ;

use Magento\Framework\App\Filesystem\DirectoryList;
use ISN\CheckBox\Model\CheckBoxValueFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
class Index extends \Magento\Framework\App\Action\Action
{
     /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultjsonFactory;
    private $logger;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;
    /**
     * @var Tychons\SecondTask\Model\ProductFactory;
     */
    protected $checkboxvalueFactory;
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
        checkboxvalueFactory $checkboxvalueFactory,\Psr\Log\LoggerInterface $logger,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        CheckoutSession $checkoutSession
     
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->cookieManager = $cookieManager;
        $this->checkboxvalueFactory = $checkboxvalueFactory;
        $this->resultjsonFactory = $resultjsonFactory;   $this->logger = $logger;
        $this->filter            = $filter;
        $this->quoteRepository = $quoteRepository;
        $this->request=$request;
        $this->checkoutSession = $checkoutSession;
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
                $quoteId=$this->checkoutSession->getQuote()->getId();
                echo $quoteId;
                $quote = $this->quoteRepository->get($quoteId); // Get quote by id
                $quote->setData('checkBoxValue', $cookievalue); // Fill data
                $this->quoteRepository->save($quote);

/* 
                $name=$this->checkboxvalueFactory->create();
                $name->addData(['checkBoxValue'=>$cookievalue]);
                $name->save(); */
              
            }
            else{
                $quoteId=$this->checkoutSession->getQuote()->getId();
                echo $quoteId;
                $quote = $this->quoteRepository->get($quoteId); // Get quote by id
                $quote->setData('checkBoxValue',''); // Fill data
                $this->quoteRepository->save($quote);
                /* $name=$this->checkboxvalueFactory->create();
                $collection=$name->getCollection()->addFieldToFilter('checkBoxValue', 'welcome') ;
                foreach ($collection as $item)
                {
                    $iidd=$item->getEntityId();
                    echo $iidd;
                    $studentobj=$name->load($iidd);
                    $studentobj->delete();
                } */

            } 
        }
       
     }
}
