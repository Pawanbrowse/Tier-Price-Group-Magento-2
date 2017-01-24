<?php
namespace Ocodewire\Pricegroup\Block\Adminhtml\Pricegroup\Edit\Tab;
use Magento\Config\Model\Config\Source\Yesno as BooleanOptions;
use Magento\Cms\Model\ResourceModel\Block\CollectionFactory as CmsCollectionFactory;

class edit extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;
    protected $booleanOptions;
    protected $cmsCollectionFactory;

    protected $_template = 'tier.phtml';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        BooleanOptions $booleanOptions,
        CmsCollectionFactory $cmsCollectionFactory,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        $this->booleanOptions   = $booleanOptions;
        $this->cmsCollectionFactory   = $cmsCollectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
		/* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('pricegroup_pricegroup');
        
        //$this->cmsBlocks();
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Item Information')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'title',
            'text',
            array(
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
            )
        );
		
        $fieldset->addField(
            'description',
            'text',
            array(
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'required' => true,
            )
        );
        
		/*{{CedAddFormField}}*/
        
        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();   
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Item Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Item Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
    
    public function cmsBlocks()
    {
        $cms_items = $this->cmsCollectionFactory->create()->addFieldToSelect('*')->addFieldToFilter('is_active',1);
        
        $blocksArray = array(""=>"Select Block");
        
        foreach($cms_items as $value)
        {
			$blocksArray[$value->getIdentifier()] = $value->getTitle();
		}
		
		return $blocksArray;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
