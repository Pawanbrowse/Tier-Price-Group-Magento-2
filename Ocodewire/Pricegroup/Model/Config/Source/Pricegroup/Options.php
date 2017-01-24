<?php
/**
 * Copyright © 2015 Ocodewirecommerce. All rights reserved.
 */
namespace Ocodewire\Pricegroup\Model\Config\Source\Pricegroup;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;
use Ocodewire\Pricegroup\Model\ResourceModel\Pricegroup\CollectionFactory as ItemsCollectionFactory;
 
/**
 * Custom Attribute Renderer
 *
 * @author      Webkul Core Team <support@webkul.com>
 */
class Options extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @var OptionFactory
     */
    protected $optionFactory;

    protected $itemsCollectionFactory;
 
    /**
     * @param OptionFactory $optionFactory
     */
    public function __construct(ItemsCollectionFactory $itemsCollectionFactory)
    {
        $this->itemsCollectionFactory = $itemsCollectionFactory->create();  
        //you can use this if you want to prepare options dynamically  
    }
 
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        /* your Attribute options list*/
        /*$this->_options=[ ['label'=>'Select Options', 'value'=>''],
                          ['label'=>count($this->itemsCollectionFactory), 'value'=>count($this->itemsCollectionFactory)],
                          ['label'=>'Option2', 'value'=>'2'],
                          ['label'=>'Option3', 'value'=>'3']
                         ];*/

        $this->_options = array(array('label'=>'Select Options', 'value'=>''));

        foreach($this->itemsCollectionFactory as $item)
        {
            $temp_options['label']  = $item->getId();
            $temp_options['value']  = $item->getId();
            $this->_options[] = $temp_options;
        }                
        return $this->_options;
    }
 
    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string|bool
     */
    public function getOptionText($value)
    {
        foreach ($this->getAllOptions() as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }
 
    /**
     * Retrieve flat column definition
     *
     * @return array
     */
    public function getFlatColumns()
    {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        return [
            $attributeCode => [
                'unsigned' => false,
                'default' => null,
                'extra' => null,
                'type' => Table::TYPE_INTEGER,
                'nullable' => true,
                'comment' => 'Custom Attribute Options  ' . $attributeCode . ' column',
            ],
        ];
    }
}
