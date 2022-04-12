<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ISN\CheckBox\ViewModel;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use ISN\CheckBox\Model\GridFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
class CheckBox implements ArgumentInterface 
{
    /**
    * @var Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;
    protected $gridFactory;
    protected $quote;
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;
    /**
    * Constructor
    *
    * @param Magento\Framework\App\Config\ScopeConfigInterface
    */
    public function __construct(ScopeConfigInterface $scopeConfig,
    GridFactory $gridFactory,  CheckoutSession $checkoutSession,
    \Magento\Backend\Model\Session\Quote $quote)
    {
        $this->scopeConfig =$scopeConfig;
        $this->gridFactory = $gridFactory;
        $this->quote=$quote;
        $this->checkoutSession = $checkoutSession;
    }
    public function  getCheckboxText(){
        return __('CheckBox Information');
    }
    /**
    * Get Config Value 
    * If yes display text in storefront
    *
    * @param Magento\Framework\App\Config\ScopeConfigInterface
    */
    public function getCheckBoxEditPagevalue()
    {   
        $zz= $this->quote->getOrder()->getIncrementId();
        $name=$this->gridFactory->create();
        $studentobj=$name->load($zz);
        $cbep=$studentobj->getMagenestcustomcolumn();
       if($cbep=='')
       {
           $status="Not Checked";
       }
       else{
            $status=$cbep;
       }
       return $status;

    }
}