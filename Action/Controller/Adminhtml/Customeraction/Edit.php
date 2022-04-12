<?php
namespace ISN\Action\Controller\Adminhtml\Customeraction;
 
use Magento\Framework\Controller\ResultFactory;
 
class Edit extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    { 
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);/* echo "hlooooo"; */
        return $resultPage;
    }
}