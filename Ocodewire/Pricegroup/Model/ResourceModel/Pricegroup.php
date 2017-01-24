<?php
/**
 * Copyright © 2015 Ocodewire. All rights reserved.
 */
namespace Ocodewire\Pricegroup\Model\ResourceModel;

/**
 * Megamenu resource
 */
class Pricegroup extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('ocodewire_pricegroup_pricegroup', 'id');
    }

  
}
