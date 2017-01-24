<?php
namespace Ocodewire\Pricegroup\Block\Adminhtml\Pricegroup\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('checkmodule_pricegroup_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Pricegroup Information'));
    }
}
