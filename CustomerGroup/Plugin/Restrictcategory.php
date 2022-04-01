<?php
namespace ISN\CustomerGroup\Plugin;
 
class Restrictcategory
{
    protected $_url;
    protected $_responseFactory;
     /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeInfo;
    /**
     * @var \ISN\CustomerGroup\Helper\Myhelper
     */
    protected $helper;
    public function __construct(
        \Magento\Framework\UrlInterface $url,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Store\Model\StoreManagerInterface $storeInfo,
        \ISN\CustomerGroup\Helper\Myhelper $helper
    ) {
        $this->_url = $url;
        $this->_responseFactory = $responseFactory;
        $this->storeInfo=$storeInfo;
        $this->helper=$helper;
    }
 
    public function afterGetIsActive(\Magento\Catalog\Model\Category $category)
    {
        if($category->getData('store_id')==2)//For MyStore site
        {   $CustomerGroup = $this->helper->getGroupId();
            if($CustomerGroup=="Wholesale"){
                $HomePageUrl=$this->storeInfo->getStore()->getBaseUrl();
                $customRedirectionUrl = $this->_url->getUrl($HomePageUrl);

                $this->_responseFactory->create()->setRedirect($customRedirectionUrl)->sendResponse();
                exit;
            }
            else{
                return $category;
            }
        
        }
        else{
            return $category;
        }
    }
}
?>