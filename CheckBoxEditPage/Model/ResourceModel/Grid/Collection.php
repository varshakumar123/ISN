<?php
namespace ISN\CheckBoxEditPage\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'cust_id';
	protected $_eventPrefix = 'isn_action_customeraction_collection';
	protected $_eventObject = 'customeraction_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('ISN\CheckBoxEditPage\Model\Grid', 'ISN\CheckBoxEditPage\Model\ResourceModel\Grid');
	}

}