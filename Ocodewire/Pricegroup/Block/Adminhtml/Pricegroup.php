<?php
namespace Ocodewire\Pricegroup\Block\Adminhtml;
class Pricegroup extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_pricegroup';/*block grid.php directory*/
        $this->_blockGroup = 'Ocodewire_Pricegroup';
        $this->_headerText = __('Pricegroup');
        $this->_addButtonLabel = __('Add New Item'); 
        parent::_construct();
        //$this->buttonList->remove('add');		
    }
}
