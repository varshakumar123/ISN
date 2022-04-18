<?php
namespace ISN\Badge\Block\Catalog\Product;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\AbstractProduct;
 
class View extends AbstractProduct
{
    public function __construct(Context $context, array $data)
    {
        parent::__construct($context, $data);
    }
}