<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ISN\Badge\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class MyModel implements ArgumentInterface 
{
    /**
    * @var Magento\Framework\App\Config\ScopeConfigInterface
    */
    protected $scopeConfig;

    /**
    * Constructor
    *
    * @param Magento\Framework\App\Config\ScopeConfigInterface
    */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig =$scopeConfig;
    }

    /**
    * Get Config Value 
    * If yes display text in storefront
    *
    * @param Magento\Framework\App\Config\ScopeConfigInterface
    */
    public function getConfigValue()
    {
        $status=$this->scopeConfig->getValue('badge/productbadge/enter_badge',ScopeInterface::SCOPE_STORE);
        return $status;
        
            
    }
 
}
