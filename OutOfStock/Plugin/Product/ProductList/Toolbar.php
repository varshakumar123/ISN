<?php
/**
 * @author Rakesh Jesadiya
 * @package Rbj_OutOfStock
 */
namespace ISN\OutOfStock\Plugin\Product\ProductList;

class Toolbar
{
    /**
     * @param \Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return array
     */
    public function beforeLoad(\Magento\CatalogSearch\Model\ResourceModel\Fulltext\Collection $subject, 
    $printQuery = false, $logQuery = false)
    {
        $orderBy = $subject->getSelect()->getPart(\Zend_Db_Select::ORDER);
        $outOfStockOrderBy = array('is_salable DESC');
        /* reset default product collection filter */
        $subject->getSelect()->reset(\Zend_Db_Select::ORDER);
        $subject->getSelect()->order($outOfStockOrderBy);

        return [$printQuery, $logQuery];
    }
}