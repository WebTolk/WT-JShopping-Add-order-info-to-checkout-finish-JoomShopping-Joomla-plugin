<?php

/**
 * @package       WT JShopping Add order info to checkout finish
 * * @version     1.0.0
 * * @Author      Sergey Tolkachyov and Sergey Sergevnin, https://web-tolk.ru
 * * @copyright   Copyright (C) 2025 Sergey Tolkachyov and Sergey Sergevnin
 * * @license     GNU/GPL 3.0
 * * @link        https://web-tolk.ru
 * * @since       1.0.0
 */

use Joomla\CMS\Language\Text;
use Joomla\Component\Jshopping\Site\Helper\Helper;

defined('_JEXEC') or die;

/** @var array $displayData */

extract($displayData);

/**
 * @var string                        $filePath Path to PDF file
 * @var bool                          $first    Is this first iteration or not?
 * @var Joomla\Registry\Registry|null $params   The plugin params
 */

?>
<p><?php echo Text::_(string: 'JSHOP_THANK_YOU_ORDER') ?></p>
<?php

$order_details = [];
if (!empty((float)$order->order_number) && $params->get('show_order_number', false) == true) {
        $order_details[Text::_('JSHOP_ORDER_NUMBER')] = $order->order_number;
}
if (!empty((float)$order->order_discount) && $params->get('show_order_discount', false) == true) {
        $order_details[Text::_('JSHOP_DISCOUNT')] = Helper::formatprice($order->order_discount);
}
if (!empty($order->order_tax) && $params->get('show_order_tax', false) == true) {
        $order_details[Text::_('JSHOP_TAX')] = Helper::formatprice($order->order_tax);
}
if (!empty($order->order_subtotal) && $params->get('show_order_subtotal', false) == true) {
        $order_details[Text::_('JSHOP_SUBTOTAL')] = Helper::formatprice($order->order_subtotal);
}
if (!empty($order->getPaymentName()) && $params->get('show_order_payment_method', false) == true) {
        $order_details[Text::_('JSHOP_FINISH_PAYMENT_METHOD')] = $order->getPaymentName();
}
if (!empty((float)$order->order_payment) && $params->get('show_order_payment_price', false) == true) {
        $order_details[Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_PAYMENT_PRICE')] = Helper::formatprice($order->order_payment);
}
if (!empty($order->getShippingName()) && $params->get('show_order_shipping_method', false) == true) {
        $order_details[Text::_('JSHOP_FINISH_SHIPPING_METHOD')] = $order->getShippingName();
}
if (!empty($order->order_shipping) && $params->get('show_order_shipping_price', false) == true) {
        $order_details[Text::_('JSHOP_SHIPPING_PRICE')] = Helper::formatprice($order->order_shipping);
}
if (!empty($order->order_total) && $params->get('show_total', false) == true) {
        $order_details[Text::_('JSHOP_PRICE_TOTAL')] = Helper::formatprice($order->order_total);
}

if (!empty($order_details)) :
    echo '<p class="order-info-header fs-4">' . Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_ORDER_DETAILS_LABEL') . '</p>';
    foreach ($order_details as $key => $value) {
        echo '<p><span class="order-info-label fw-bold">' . $key . '</span>: <span class="order-info-value">' . $value . '</span></p>';
    }
endif;

if ($params->get('show_products', false) == true) : ?>
    <div class="product-details-section mt-5 mb-5">
        <p class="order-info-header fs-5 mb-3"><?php
            print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_PRODUCT_DETAILS_LABEL') ?></p>
        <?php
        foreach ($order->items as $item) {
            echo '<p class="mt-0 mb-0"><span class="order-info-label fw-bold">' . Text::_('JSHOP_NAME_PRODUCT') .
                '</span>: <span class="order-info-value">' . $item->product_name . '</span></p>';
        } ?>
    </div>
<?php
endif;
$order_address = [];

if (!empty($order->d_state)) {
    $order_address[Text::_('JSHOP_STATE')] = $order->d_state;
}
if (!empty($order->d_city)) {
    $order_address[Text::_('JSHOP_CITY')] = $order->d_city;
}
if (!empty($order->d_street)) {
    $order_address[Text::_('JSHOP_STREET_NR')] = $order->d_street;
}
if (!empty($order->d_apartment)) {
    $order_address[Text::_('JSHOP_APARTMENT')] = $order->d_apartment;
}
if (!empty($order->d_phone)) {
    $order_address[Text::_('JSHOP_TELEFON')] = $order->d_phone;
}
if (!empty($order_address)) :
    if ($params->get('show_order_address', false) == true) { ?>
        <div class="address-details-section mt-5 mb-5">
            <?php
            echo '<p class="order-info-header fs-5">' . Text::_(
                    string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_ORDER_ADDRESS'
                ) . '</p>';
            foreach ($order_address as $key => $value) {
                echo '<p><span class="order-info-label fw-bold">' . $key . '</span>: <span class="order-info-value">' . $value . '</span></p>';
            } ?>
        </div>
        <?php
    }
endif;
if (!empty($shipping_params_data = $order->getShippingParamsData()) && $params->get('show_order_shipping_params_data', false) == true) :

        echo '<p class="order-info-header fs-5">' . Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_SHIPPING_PARAMS_DATA') . '</p>';
        ?>
        <table class="table table-hover">
            <?php
            $shipping_params_names_tmpl = $order->wtjshoppingaddorderinfotocheckoutfinish_shipping_params_names;
            foreach ($shipping_params_names_tmpl as $key => $value) {
                echo '<tr><td>' . (!empty ($shipping_params_data[$key]) ? $shipping_params_names_tmpl[$key] :
                        '') . '</td><td>' . $shipping_params_data[$key] . '</td></tr>';
            }
            ?>
        </table>
        <?php
endif;
