<?php
/**
 * Copyright © 2015 Ocodewire. All rights reserved.
 */

namespace Ocodewire\Pricegroup\Model;

use Magento\Framework\Exception\PricegroupException;

/**
 * Megamenutab megamenu model
 */
class Pricegroup extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\Db $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('Ocodewire\Pricegroup\Model\ResourceModel\Pricegroup');
    }

   
}
