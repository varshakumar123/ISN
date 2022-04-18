<?php
namespace ISN\Badge\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
class Block extends \Magento\Framework\View\Element\Template
{  protected $scopeConfig;
	public function __construct(\Magento\Framework\View\Element\Template\Context $context,ScopeConfigInterface $scopeConfig)
	{
		$this->scopeConfig =$scopeConfig;
		parent::__construct($context);
	}

	public function sayHello()
	{
		return __('Hello World');
	} 
	public function getConfigValue()
    {
        $status=$this->scopeConfig->getValue('badge/productbadge/enter_badge',ScopeInterface::SCOPE_STORE);
        return $status;
        
            
    }
}