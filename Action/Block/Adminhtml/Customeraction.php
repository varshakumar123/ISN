<?php
namespace ISN\Action\Block\Adminhtml;

class Customeraction extends \Magento\Backend\Block\Widget\Grid\Container
{

	protected function _construct()
	{
		$this->_controller = 'adminhtml_customeraction';
		$this->_blockGroup = 'ISN_Action';
		$this->_headerText = __('Customeraction');
		//$this->_addButtonLabel = __('Create New Post');
		parent::_construct();
	}
}