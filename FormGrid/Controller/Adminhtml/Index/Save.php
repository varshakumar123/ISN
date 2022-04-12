<?php
namespace ISN\FormGrid\Controller\Adminhtml\Index;
 
class Save extends \Magento\Backend\App\Action
{
 
    protected $customFactory;
    protected $adapterFactory;
    protected $uploader;
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \ISN\FormGrid\Model\CustomFactory $customFactory
    ) {
        parent::__construct($context);
        $this->customFactory = $customFactory;
    }
 
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        try {
            $model = $this->customFactory->create();
            $model->addData([
            "firstname" => $data['firstname'],
            "lastname" => $data['lastname'],
            "email" => $data['email'],
            "password" => $data['password'],
            ]);
        
        $saveData = $model->save();
        if($saveData){
            $this->messageManager->addSuccess( __('User Registered Successfully !') );
        }

        }catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('*/*/index');
 
    }
 
}