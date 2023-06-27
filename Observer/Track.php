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

namespace Moebel\Salestracking\Observer;

use Magento\Framework\Event\ObserverInterface;

class Track implements ObserverInterface
{

    /**
     * Define scopeConfig
     *
     * @var object
     **/
    protected $scopeConfig;

    /**
     * Define block
     *
     * @var object
     **/
    protected $block;

    /**
     * Define catalogSession
     *
     * @var object
     **/
    protected $catalogSession;
    protected $request;


    /**
     * Constructor autoload
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Catalog\Model\Session $catalogSession
     * @param \Moebel\Salestracking\Block\Index $block
     * @param \Magento\Framework\App\RequestInterface $request
     *
     */
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Catalog\Model\Session $catalogSession, \Moebel\Salestracking\Block\Index $block, \Magento\Framework\App\RequestInterface $request)
    {

        $this->scopeConfig = $scopeConfig;
        $this->block = $block;
        $this->catalogSession = $catalogSession;
        $this->request = $request;

    }//end __construct()


    /**
     * Retrieve sale tracking status
     *
     * @param string $observer With a observer object
     *
     * @return void
     **/
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ( $this->block->isModuleEnable() === '1' ) {
            $trackingType = $this->block->getTrackingType();
            $trackingName = explode(',', $this->block->getTrackingName());
            $trackingValue = $this->block->getTrackingValue();
            $salesTracked = $this->catalogSession->getSalesTracked();

            if ( $salesTracked !== true ) {
                if ( $trackingType === '1' ) {
                    if ( empty($trackingName) === false ) {
                        $find = false;
                        if ( isset($_SERVER['HTTP_REFERER']) === true ) {
                            $referer = $_SERVER['HTTP_REFERER'];
							if(!empty($referer))
							{
								foreach ($trackingName as $track) {
									if(!empty($track))
									{
										$pos = strpos($referer, $track);
										if ( $pos !== false ) {
											$this->catalogSession->setSalesTracking($track);
											$this->catalogSession->setSalesTracked(true);
											$find = true;
										}//end if
									}else{
										$this->catalogSession->setSalesTracking($track);
										$this->catalogSession->setSalesTracked(true);
										$find = true;
									}
								}
							}
                        }//end if

                        if ( $find === false ) {
                            $this->catalogSession->setSalesTracking(false);
                            $this->catalogSession->setSalesTracked(false);
                        }//end if
                    }//end if
                } else if ( $trackingType === '2' ) {
                    if ( empty($trackingName) === false ) {
                        $find = false;
                        foreach ($trackingName as $track) {
                            if ( $this->request->getParam("$track") !== '' ) {

                                if ( $trackingValue !== '' ) {
                                    if ( $trackingValue === $this->request->getParam("$track") ) {
                                        $this->catalogSession->setSalesTracking($this->request->getParam("$track"));
                                        $this->catalogSession->setSalesTracked(true);
                                        $find = true;
                                    }
                                }
                            }//end if
                        }

                        if ( $find === false ) {
                            $this->catalogSession->setSalesTracking(false);
                            $this->catalogSession->setSalesTracked(false);
                        }//end if
                    }//end if
                } else {
                    $this->catalogSession->setSalesTracking(true);
                    $this->catalogSession->setSalesTracked(true);
                }//end if
            }//end if
        }//end if

    }//end execute()


}//end class
