<?php
namespace ISN\Badge\Plugin;

class ProductList
{   
    protected $layout;

    public function __construct(
        \Magento\Framework\View\LayoutInterface $layout
    ) {
        $this->layout = $layout;
    }

    public function aroundGetProductDetailsHtml(
        \Magento\Catalog\Block\Product\ListProduct $subject,
        \Closure $proceed,
        \Magento\Catalog\Model\Product $product
    ) {
        return $this->layout->createBlock('ISN\Badge\Block\Block')->setProduct($product)->setTemplate('ISN_Badge::product/list/itemss.phtml')->toHtml();
    }               
}