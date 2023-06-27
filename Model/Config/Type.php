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
namespace Moebel\Salestracking\Model\Config;

class Type implements \Magento\Framework\Option\ArrayInterface
{


    /**
     * * Retrieve option array for status
     *
     * @return array
     **/
    public function toOptionArray()
    {
        return [
            [
                'value' => 0,
                'label' => __('Select'),
            ],
            [
                'value' => 1,
                'label' => __('Referer'),
            ],
            [
                'value' => 2,
                'label' => __('Url'),
            ],
        ];

    }//end toOptionArray()


}//end class
