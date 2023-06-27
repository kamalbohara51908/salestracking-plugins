<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the moebel.de Einrichten & Wohnen AG License
 * that is available through the world-wide-web at this URL:
 * https://sales1.moebel.de/licenses/magento.txt
 */

/**
 * @category   Sales Tracking
 * @package    Moebel_Salestracking
 * @subpackage etc
 * @author     moebel.de <salestracking@moebel.de>
 * @copyright  Copyright (c) 2020 moebel.de Einrichten & Wohnen AG (https://www.moebel.de)
 * @link       https://www.moebel.de
 */
namespace Moebel\Salestracking\Block;

class Index extends \Magento\Framework\View\Element\Template
{

    /**
     * Define scopeConfig
     *
     * @var object
     **/
    protected $scopeConfig;

    /**
     * Define checkout session
     *
     * @var object
     **/
    protected $checkoutSession;

    /**
     * Define price helper
     *
     * @var object
     **/
    protected $priceHelper;

    /**
     * Define Catalog session
     *
     * @var object
     **/
    protected $catalogSession;


    /**
     * Constructor autoload
     *
     * @param Context                         $context         With a product context
     * @param ScopeConfigInterface            $scopeConfig     With a store config
     * @param \Magento\Checkout\Model\Session $checkoutSession With a checkout session
     * @param \Magento\Catalog\Model\Session  $catalogSession  With a catalog session
     * @param Data                            $priceHelper     With a helper class
     * @param array                           $data            With a data array
     **/
    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Catalog\Model\Session $catalogSession, \Magento\Framework\Pricing\Helper\Data $priceHelper, array $data=[])
    {
        $this->scopeConfig     = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->priceHelper     = $priceHelper;
        $this->catalogSession  = $catalogSession;
        parent::__construct($context, $data);

    }//end __construct()


    /**
     * Preparing layout
     *
     * @return \Moebel\Salestracking\Block\Index
     **/
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();

    }//end _prepareLayout()


    /**
     * Retrieve sale tracking status
     *
     * @return boolean
     **/
    public function getSalesTrackingStatus()
    {
        if ($this->catalogSession->getSalesTracking() !== false) {
            return true;
        }

        return false;

    }//end getSalesTrackingStatus()


    /**
     * Retrieve current order
     *
     * @return object
     **/
    public function getOrder()
    {
        return $order = $this->checkoutSession->getLastRealOrder();

    }//end getOrder()


    /**
     * Retrieve umsatz
     *
     * @return String
     **/
    public function getUmsatz()
    {
        $umsatzInVer = $this->getConfig('setting/general/umsatz_in_ver');
        $order       = $this->getOrder();
        if ($umsatzInVer === '1') {
            $gt = number_format($order->getGrandTotal(), 2);
        } else {
            $gt = number_format(($order->getGrandTotal() - $order->getShippingAmount()), 2);
        }

        return $gt;

    }//end getUmsatz()


    /**
     * Retrieve items sku
     *
     * @return String
     **/
    public function getSkuOfOrderItem()
    {
        $order     = $this->getOrder();
        $sku       = [];
        $skustring = '';
        foreach ($order->getAllVisibleItems() as $_item) {
            $sku[] = $_item->getSku();
        }

        if (empty($sku) === false) {
            $skustring = implode(',', $sku);
        }

        return $skustring;

    }//end getSkuOfOrderItem()


    /**
     * Retrieve config variable
     *
     * @param string $configPath With a path of system variable
     *
     * @return String
     **/
    protected function getConfig($configPath)
    {
        return $this->scopeConfig->getValue($configPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

    }//end getConfig()


    /**
     * Check module is enable or not
     *
     * @return boolean
     **/
    public function isModuleEnable()
    {
        return $this->getConfig('setting/general/enable');

    }//end isModuleEnable()


    /**
     * Retrieve key value
     *
     * @return String
     **/
    public function getKey()
    {
        return $this->getConfig('setting/general/key');

    }//end getKey()


    /**
     * Retrieve attribution
     *
     * @return String
     **/
    public function getAttribution()
    {
        if ($this->getConfig('setting/general/attribution') === '1') {
            return 'Ja';
        } else {
            return 'Nein';
        }

    }//end getAttribution()


    /**
     * Retrieve attribution value
     *
     * @return String
     **/
    public function getAttributionValue()
    {
        return $this->getConfig('setting/general/attribution_value');

    }//end getAttributionValue()


    /**
     * Retrieve tracking type
     *
     * @return String
     **/
    public function getTrackingType()
    {
        return $this->getConfig('setting/general/tracking_type');

    }//end getTrackingType()


    /**
     * Retrieve tracking name
     *
     * @return String
     **/
    public function getTrackingName()
    {
        return $this->getConfig('setting/general/tracking_name');

    }//end getTrackingName()


    /**
     * Retrieve tracking value
     *
     * @return String
     **/
    public function getTrackingValue()
    {
        return $this->getConfig('setting/general/tracking_value');

    }//end getTrackingValue()


    /**
     * Retrieve formated price
     *
     * @param string $price With a price
     *
     * @return String
     **/
    public function getFormatedPrice($price)
    {
        return $this->priceHelper->currency($price, true, false);

    }//end getFormatedPrice()


}//end class
