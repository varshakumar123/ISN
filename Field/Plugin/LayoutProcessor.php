<?php
namespace ISN\Field\Plugin;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
class LayoutProcessor
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    protected $scopeConfig;
    public function __construct(\Psr\Log\LoggerInterface $logger,ScopeConfigInterface $scopeConfig
       ) {
            $this->logger = $logger;
            $this->scopeConfig =$scopeConfig;
        }
       
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $status=$this->scopeConfig->getValue('topseller/general/enable',ScopeInterface::SCOPE_STORE);
        $a=10;
         $this->logger->debug('depersonalize plugin from catalog module..'.$status);
if($status==1){
    $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
    ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_field'] = [
        'component' => 'Magento_Ui/js/form/element/abstract',
        'config' => [
            'customScope' => 'shippingAddress.custom_attributes',
            'template' => 'ui/form/field',
            'elementTmpl' => 'ui/form/element/input',
            'options' => [],
            'id' => 'custom-field'
        ],
        'dataScope' => 'shippingAddress.custom_attributes.custom_field',
        'label' => 'Custom Field',
        'provider' => 'checkoutProvider',
        'visible' => true,
        'validation' => [],
        'sortOrder' => 250,
        'id' => 'custom-field'
    ];


    return $jsLayout;
}
else{
    $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
    ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_field'] = [
        'component' => 'Magento_Ui/js/form/element/abstract',
        'config' => [
            'customScope' => 'shippingAddress.custom_attributes',
            'template' => 'ui/form/field',
            'elementTmpl' => 'ui/form/element/input',
            'options' => [],
            'id' => 'custom-field'
        ],
        'dataScope' => 'shippingAddress.custom_attributes.custom_field',
        'label' => 'Custom Fieldsasas',
        'provider' => 'checkoutProvider',
        'visible' => false,
        'validation' => [],
        'sortOrder' => 250,
        'id' => 'custom-field'
    ];


    return $jsLayout;
}
       
    }
}
