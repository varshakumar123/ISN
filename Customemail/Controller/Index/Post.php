<?php
namespace ISN\Customemail\Controller\Index;
 
use Zend\Log\Filter\Timestamp;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class Post extends \Magento\Framework\App\Action\Action
{
    const XML_PATH_EMAIL_RECIPIENT_NAME = 'trans_email/ident_support/name';
    const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';
     
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;
    private $reader;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\Driver\File $reader,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $_uploaderFactory,
        array $data = []
         
        )
    {
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();
        $this->storeManager = $storeManager;
        $this->reader = $reader;
        $this->_uploaderFactory = $_uploaderFactory;
        $this->_varDirectory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        parent::__construct($context);
         
         
    }
     
    public function execute()
 {
        $post = $this->getRequest()->getPost();
        if(isset($_FILES['filename']['name'])) {
            $uploader = $this->_uploaderFactory->create(['fileId' => 'filename']);
            $workingDir = $this->_varDirectory->getAbsolutePath('importexport/');//adds the uploaded file in 'var/www/html/magento233/var/importexport/' 
            $result = $uploader->save($workingDir);
           
            $upload_document = 'CustomImage' . $uploader->getUploadedFilename();
            $filePath = $result['path'] . $result['file'];
            $fileName = $result['name'];
            $fileType = $result['type'];

            $this->_logLoggerInterface->debug("fdsdfsdf".$workingDir);
            $this->_logLoggerInterface->debug("filePath".$filePath);
            $this->_logLoggerInterface->debug("fileName".$fileName);
            $this->_logLoggerInterface->debug("fileType".$fileType);

            //To attach form values as pdf with mail
            $pdf = new \Zend_Pdf(); //Create new PDF file
            $page = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $page; 
            $page->setFont(\Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA), 20);  //Set Font 
            $page->drawText(  "File Name: ".$fileName, 50, 780); 
            $page->drawText(  "Email: ".$post['email'], 50, 740); 
            $page->drawText(  "Name: ".$post['name'], 50, 710); 
            $pdfData = $pdf->render(); // Get PDF document as a string 
            header("Content-Disposition: inline; filename=$fileName"); 
            header("Content-type: application/x-pdf"); 
            echo $pdfData; 
            $this->_logLoggerInterface->debug("pdfdata".$pdfData);
         } 
        try
        {
            $this->_inlineTranslation->suspend();       
            $sender = [
                'name' => $post['name'],
                'email' => $post['email']
            ];
            $sentToEmail = $this->_scopeConfig ->getValue('trans_email/ident_general/email',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            $sentToName = $this->_scopeConfig ->getValue('trans_email/ident_general/name',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
            
            $transport = $this->_transportBuilder
            ->setTemplateIdentifier('customemail_email_template')
            ->setTemplateOptions(
                [
                    'area' => 'frontend',
                    'store' => $this->storeManager->getStore()->getId()
                ]
                )
                ->setTemplateVars([
                    'name'  => $post['name'],
                    'email'  => $post['email']
                ])
           
                ->setFromByScope($sender)
                ->addTo($sentToEmail,$sentToName)

                ->addAttachment(file_get_contents($filePath), $fileName,$fileType)//attach file
                ->addAttachment($pdfData, 'result.pdf','application/x-pdf')//attach form values as pdf
            
                ->getTransport();
                 
                $transport->sendMessage();

                $this->_inlineTranslation->resume();
                $this->messageManager->addSuccess('Email sent successfully');
                $this->_redirect('customemail/index/index');
                 
        } catch(\Exception $e){
            $this->messageManager->addError($e->getMessage());
            $this->_logLoggerInterface->debug($e->getMessage());
            exit;
        }  
    }
}