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
    protected $csvParser;
    protected $_productCollection;
    protected $helper;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        StoreManagerInterface $storeManager,
        \Magento\Framework\Filesystem\Driver\File $reader,
        \Magento\Framework\Filesystem $filesystem, 
        \Magento\Framework\File\Csv $csvParser,
        \Magento\Catalog\Model\Product $productCollection,
        \Magento\MediaStorage\Model\File\UploaderFactory $_uploaderFactory,
        \ISN\Customemail\Helper\Order $helper,
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
        $this->helper=$helper;
        $this->csvParser = $csvParser;
        $this->_productCollection = $productCollection;    
        $this->_varDirectory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        parent::__construct($context); 
    }
     
    public function execute()
    {
        $post = $this->getRequest()->getPost();
        if(isset($_FILES['filename']['name']))
         {
            $uploader = $this->_uploaderFactory->create(['fileId' => 'filename']);
            $workingDir = $this->_varDirectory->getAbsolutePath('importexport/');//adds the uploaded file in 'var/www/html/magento233/var/importexport/' 
            $result = $uploader->save($workingDir);
           
            $upload_document = 'CustomImage' . $uploader->getUploadedFilename();
            $filePath = $result['path'] . $result['file'];
            $fileName = $result['name'];
            $fileType = $result['type'];

            //To attach form values as pdf with mail
            $pdf = new \Zend_Pdf(); //Create new PDF file
            $page = $pdf->newPage(\Zend_Pdf_Page::SIZE_A4);
            $pdf->pages[] = $page; 
            $page->setFont(\Zend_Pdf_Font::fontWithName(\Zend_Pdf_Font::FONT_HELVETICA), 20);  //Set Font 
            $page->drawText(  "File Name: ".$fileName, 50, 780); 
            $page->drawText(  "Email: ".$post['email'], 50, 740); 
            $page->drawText(  "Name: ".$post['name'], 50, 710); 
            $pdfData = $pdf->render(); // Get PDF document as a string 
            
            //To Place Order On uploading CSV file
            $file=$filePath; 
            if($fileType=="text/csv")
            {
                $csv = array();
                $lines = file($file, FILE_IGNORE_NEW_LINES);
                $len=count($lines);
                foreach ($lines as $key => $value)
                {
                    $csv[$key] = str_getcsv($value);
                }
                for($i = 0; $i <$len ; $i++) 
                {
                    
                    $sku = $csv[$i][0];//00
                    $productId = $this->_productCollection->getIdBySku($sku);
                    $qty = $csv[$i][1];//01
                    $orderInfo =[
                        'currency_id'  => 'USD',
                        'email'        => $post['email'], //customer email id
                        'address' =>[
                        'firstname'    => $post['name'],
                        'lastname'     => 'Testname',
                        'prefix' => '',
                        'suffix' => '',
                        'street' => 'B1 Abcd street',
                        'city' => 'Los Angeles',
                        'country_id' => 'US',
                        'region' => 'California',
                        'region_id' => '12', // State region id
                        'postcode' => '45454',
                        'telephone' => '1234512345',
                        'fax' => '12345',
                        'save_in_address_book' => 1
                        ],
                        'items'=>
                            [
                                ['product_id'=>$productId,'qty'=>$qty], //simple product
                            ]
                        ];
                    $helpers = $this->helper->createOrder($orderInfo);
                } 
            }
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
         }        
          
    }
}