<?php
namespace Ocodewire\Pricegroup\Controller\Adminhtml\Pricegroup;

use Magento\Framework\App\Filesystem\DirectoryList;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
	public function execute()
    {
		
        $data = $this->getRequest()->getParams();

        if ($data) 
        {
            $model       = $this->_objectManager->create('Ocodewire\Pricegroup\Model\Pricegroup');

            $store       = $this->_objectManager->create('Magento\Store\Model\StoreManagerInterface');
            
			$id          = $this->getRequest()->getParam('id');

            if ($id) {
                $model->load($id);
            }
			
            $model->setPriceData(json_encode($data['cus_price']));
			
            try {
                $model->save();

                if($id)
                {
                    $tirePrices = array();

                    if(count($data['cus_price'])>0)
                    {
                        foreach($data['cus_price'] as $priceGroup)
                        {
                            $tirePrices[] = array(
                                "cust_group"=>"32000",
                                "price_qty"=>$priceGroup['price_qty'],
                                "price"=>$priceGroup['price'],
                                "website_id"=>0,
                                "all_groups"=>"1"
                            );
                        }
                    }

                    $prductCollection  = $this->_objectManager->create('Magento\Catalog\Model\ResourceModel\Product\Collection')->addFieldToFilter('ocode_price_group_id',$id);

                    
                    if(count($prductCollection)>0)
                    {
                        foreach($prductCollection as $prod)
                        {
                            $currentProduct = $this->_objectManager->create("Magento\Catalog\Model\Product")->load($prod->getId());

                            $currentProduct->setTierPrice($tirePrices);

                            try
                            {
                                $currentProduct->save();
                            }
                            catch(Exception $e)
                            {
                                echo $e->getMessage();
                                die();
                            }
                        }
                    }
                }

                $this->messageManager->addSuccess(__('The Data Has been Saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId(), '_current' => true));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                echo $e->getMessage();
                die();
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('banner_id' => $this->getRequest()->getParam('banner_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
}
