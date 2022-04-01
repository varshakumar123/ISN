<?php
namespace ISN\Customemail\Mail;
 
class MessageFactory extends \Magento\Framework\Mail\MessageInterfaceFactory
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;
 
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Extait\\Attachment\\Mail\\Message')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }
 
    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Magento\Framework\Mail\MessageInterface
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}