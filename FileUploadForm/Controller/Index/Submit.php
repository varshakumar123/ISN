<?php
namespace ISN\FileUploadForm\Controller\Index;
 
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
//use ISN\FileUploadForm\Model\FileUploadFormFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
 
class Submit extends Action
{
    protected $resultPageFactory;
    //protected $fileuploadformFactory;
 
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
       // fileuploadformFactory $fileuploadformFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
      //  $this->fileuploadformFactory = $fileuploadformFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        try {
            $data = (array)$this->getRequest()->getPost();
            if ($data) {
               // $model = $this->fileuploadformFactory->create();
               // $model->setData($data)->save();
                $this->messageManager->addSuccessMessage(__("Data Saved Successfully."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can\'t submit your request, Please try again."));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
 
    }
}