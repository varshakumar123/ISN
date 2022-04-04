<?php
namespace ISN\Customemail\Helper;
 
use Magento\Customer\Model\Session;
 
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_EMAIL_DEMO = 'emaildemo/email/email_demo_template';
    
    protected $inlineTranslation;
    protected $transportBuilder;
    protected $template;
    protected $storeManager;
 
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \ISN\Customemail\Model\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) 
    {
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }
 
    public function generateTemplate()
    {
    // path for attachment File
        $attachmentFile = '/Links.odt';
    $fileName = 'Links.odt';
        
        $emailTemplateVariables['message'] = 'This is a test message by meetanshi.';
        //load your email tempate
        $this->_template  = $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_DEMO,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->_storeManager->getStore()->getStoreId()
        );
        $this->_inlineTranslation->suspend();
 
        $this->_transportBuilder->setTemplateIdentifier($this->_template)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->_storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars($emailTemplateVariables)
                ->setFrom([
                    'name' => 'vk',
                    'email' => 'varshakumar12032@gmail.com',
                ])
                ->addTo('varshakumar12032@gmail.com', 'Your Name')
                ->addAttachment($attachmentFile,$fileName); //Attachment goes here.
 
        try {
            $transport = $this->_transportBuilder->getTransport();
            $transport->sendMessage();
            $this->_inlineTranslation->resume();
        } catch (\Exception $e) {
            echo $e->getMessage(); die;
        }
    }
}