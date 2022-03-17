<?php
namespace ISN\Action\Model\ResourceModel\CustomerAction;

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
		$this->_init('ISN\Action\Model\CustomerAction', 'ISN\Action\Model\ResourceModel\CustomerAction');
	}

}