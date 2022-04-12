<?php
namespace ISN\FormGrid\Controller\Adminhtml\Index;
 
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use ISN\FormGrid\Model\CustomFactory;
use ISN\FormGrid\Model\ResourceModel\Custom as DataResourceModel;
 
class InlineEdit extends \Magento\Backend\App\Action
{
    protected $jsonFactory;
    private $CustomFactory;
    private $dataResourceModel;
 
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        CustomFactory $CustomFactory,
        DataResourceModel $dataResourceModel)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->CustomFactory = $CustomFactory;
        $this->dataResourceModel = $dataResourceModel;
    }
 
    public function execute()
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];
 
        if ($this->getRequest()->getParam('isAjax'))
        {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems))
            {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            }
            else
            {
                foreach (array_keys($postItems) as $modelid)
                {
                    $model = $this->CustomFactory->create();
                    $this->dataResourceModel->load($model, $modelid);
                    try
                    {
                        $model->setData(array_merge($model->getData(), $postItems[$modelid]));
                        $this->dataResourceModel->save($model);
                    }
                    catch (\Exception $e)
                    {
                        $messages[] = "[Error : {$modelid}]  {$e->getMessage()}";
                        $error = true;
                    }
                }
            }
        }
 
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error]);
    }  
}