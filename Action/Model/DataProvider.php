<?php
namespace ISN\Action\Model;
 
use ISN\Action\Model\CustomerActionFactory;


class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{ 
    protected $customeractionFactory;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CustomerActionFactory $customeractionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->customeractionFactory = $customeractionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return [];
    }
}


