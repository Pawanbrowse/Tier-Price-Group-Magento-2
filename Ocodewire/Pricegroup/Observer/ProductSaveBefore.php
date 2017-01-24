<?php

/**
 * *
 *  Copyright © 2016 Magestore. All rights reserved.
 *  See COPYING.txt for license details.
 *  
 */

namespace Ocodewire\Pricegroup\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class OrderPlaceAfter
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class ProductSaveBefore implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_pricegroup;
    protected $_request;
    protected $_product;
    protected $_storeManager;

    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Ocodewire\Pricegroup\Model\Pricegroup $pricegroup,
        \Magento\Catalog\Model\Product $product,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_pricegroup = $pricegroup;
        $this->_request = $request;
        $this->_product = $product;
        $this->_storeManager = $storeManager;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $postedProduct      = $this->_request->getParam('product');
        
        if($postedProduct)
        {
            $postedPriceGroupId = $postedProduct['ocode_price_group_id'];
           
            $product            = $observer->getProduct();

            $origData           = $this->_product->load($product->getId());

            $lastGroupId        = $origData->getOcodePriceGroupId();

            if($postedPriceGroupId != $lastGroupId)
            {
                $tirePrices = array();

                $priceGroupDetails  =  $this->_pricegroup->load($postedPriceGroupId);

                if($priceGroupDetails)
                {
                    $priceData = $priceGroupDetails->getPriceData();

                    if($priceData!="")
                    {
                        $priceData = json_decode($priceData);
                    }

                    if(is_array($priceData))
                    {
                        foreach($priceData as $priceGroup)
                        {
                            $tirePrices[] = array(
                                                "cust_group"=>"32000",
                                                "price_qty"=>$priceGroup->price_qty,
                                                "price"=>$priceGroup->price,
                                                "website_id"=>$this->_storeManager->getStore()->getWebsiteId(),
                                                "all_groups"=>"1"
                                            );
                        }
                    }
                }

                $product->setTierPrice($tirePrices);
            }
        }

        //echo $priceGroupId = $_product->getOcodePriceGroupId();

        //$_product->setName("Test");

        //die();
        /*
        if($postedProduct)
        {
            $_product->setName("Test");
            $_product->save();
        }*/

        //$price_group_details = $this->pricegroup->load($priceGroupId);


    }
}
