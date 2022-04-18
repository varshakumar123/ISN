<?php
namespace ISN\Badge\Model\Config\Source;

class ListMode implements \Magento\Framework\Data\OptionSourceInterface
{
 public function toOptionArray()
 {
  return [
    ['value' => '', 'label' => __('-- Select an Badge --')],
    ['value' => 'New', 'label' => __('New')],
    ['value' => 'HotDeal', 'label' => __('HotDeal')],
    ['value' => 'Sale', 'label' => __('Sale')],
    ['value' => 'BestSeller', 'label' => __('BestSeller')]
  ];
 }
}