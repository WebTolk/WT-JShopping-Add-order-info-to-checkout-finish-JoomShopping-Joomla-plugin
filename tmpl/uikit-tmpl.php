<?php

/**
 * @package    Content - WT JShopping Add order info to checkout finish
 * @version       1.0.0
 * @Author        Sergey Tolkachyov, https://web-tolk.ru
 * @copyright     Copyright (c) 2025 Sergey Tolkachyov
 * @license       GNU/GPL http://www.gnu.org/licenses/gpl-3.0.html
 * @since         1.0.0
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;


/** @var array $displayData */

extract($displayData);

/**
 * @var string $filePath Path to PDF file
 * @var bool $first Is this first iteration or not?
 * @var Joomla\Registry\Registry|null $params The plugin params
 */
?>

<div class="uk-card uk-box-shadow-medium uk-margin-medium">
    <div class="uk-card-body uk-text-center">
        <div class="icon-row">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="100px" height="100px" viewBox="0 0 24 24"
                 id="check-mark-circle" data-name="Line Color" class="icon line-color">
                <polyline id="secondary" points="8 11.5 11 14.5 16 9.5"
                          style="fill: none; stroke: rgb(51, 153, 255); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                <rect id="primary" x="3" y="3" width="18" height="18" rx="9"
                      style="fill: none; stroke: rgb(51, 153, 255); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
            </svg>
        </div>
        <div class="text-row">
            <h2 class="uk-heading-small"><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_TMPL_THANK_TITLE') ?></h2>
            <p class="uk-text-large"><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_TMPL_THANK_TEXT') ?></p>
            <p class="uk-text-large uk-text-bold">
                <span class="order-info-label"><?php echo Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_ORDER_NUMBER'); ?></span>:
                <span
                        class="order-info-value"><?php echo $order->order_number; ?></span></p>
        </div>
    </div>
</div>
<ul uk-accordion>
    <li>
        <a class="uk-accordion-title uk-text-bold"
           href><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_TMPL_ORDER_DETAILS_LABEL') ?></a>
        <div class="uk-accordion-content">
            <p><?php print Text::_(string: 'JSHOP_THANK_YOU_ORDER') ?></p>

            <p class="order-info-header"><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_ORDER_DETAILS_LABEL') ?></p>

            <?php if ($params->get('show_order_number', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_ORDER_NUMBER'); ?></span>: <span
                            class="order-info-value"><?php echo $order->order_number; ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_order_discount', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_DISCOUNT'); ?></span>: <span
                            class="order-info-value"><?php echo $order->order_discount; ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_order_address', false) == true): ?>
                <p class="order-info-header"><?php echo Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_ORDER_ADDRESS'); ?>
                    :</p>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_STATE'); ?></span>: <span
                            class="order-info-value"><?php echo $order->d_state; ?></span></p>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_CITY'); ?></span>: <span
                            class="order-info-value"><?php echo $order->d_city; ?></span></p>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_STREET_NR'); ?></span>: <span
                            class="order-info-value"><?php echo $order->d_street . '-' . $order->d_street_nr; ?></span>
                </p>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_APARTMENT'); ?></span>: <span
                            class="order-info-value"><?php echo $order->d_apartment; ?></span></p>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_TELEFON'); ?></span>: <span
                            class="order-info-value"><?php echo $order->d_phone; ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_order_tax', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_TAX'); ?></span>: <span
                            class="order-info-value"><?php echo $order->order_tax; ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_order_subtotal', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_SUBTOTAL'); ?></span>: <span
                            class="order-info-value"><?php echo $order->order_subtotal; ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_order_payment_method', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_FINISH_PAYMENT_METHOD'); ?></span>: <span
                            class="order-info-value"><?php echo $order->getPaymentName(); ?></span></p>
            <?php endif; ?>

            <?php
            if (!empty((float)$order->order_payment)) {
                if ($params->get('show_order_payment_price', false) == true): ?>
                    <p>
                        <span class="order-info-label"><?php echo Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_PAYMENT_PRICE'); ?></span>:
                        <span class="order-info-value"><?php echo $order->order_payment; ?></span></p>
                <?php endif;
            }
            ?>

            <?php if ($params->get('show_order_shipping_method', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_FINISH_SHIPPING_METHOD'); ?></span>: <span
                            class="order-info-value"><?php echo $order->getShippingName(); ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_order_shipping_price', false) == true) : ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_SHIPPING_PRICE'); ?></span>: <span
                            class="order-info-value"><?php echo $order->order_shipping; ?></span></p>
            <?php endif; ?>

            <?php if ($params->get('show_total', false) == true): ?>
                <p><span class="order-info-label"><?php echo Text::_('JSHOP_PRICE_TOTAL'); ?></span>: <span
                            class="order-info-value"><?php echo $order->order_total; ?></span></p>
            <?php endif; ?>

            <p class="order-info-header"><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_PRODUCT_DETAILS_LABEL') ?></p>

            <?php if ($params->get('show_products', false) == true): ?>
                <?php foreach ($order->items as $item) : ?>
                    <p><span class="order-info-label"><?php echo Text::_('JSHOP_NAME_PRODUCT'); ?></span>: <span
                                class="order-info-value"><?php echo $item->product_name; ?></span></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php
            if ($params->get('show_order_shipping_params_data', false) == true) : ?>
                <p>
                    <span class="order-info-label"><strong><?php echo Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_SHIPPING_PARAMS_DATA'); ?></strong></span>
                </p>
                <table class="table table-hover">
                    <?php
                    $shipping_params_data = $order->getShippingParamsData();
                    $shipping_params_names_tmpl = $order->wtjshoppingaddorderinfotocheckoutfinish_shipping_params_names;
                    foreach ($shipping_params_names_tmpl as $key => $value) {
                        echo '<tr><td>' . $shipping_params_names_tmpl[$key] . '</td><td>' . (!empty($shipping_params_data[$key]) ? $shipping_params_data[$key] : '') . '</td></tr>';
                    }
                    ?>
                </table>
            <?php
            endif;
            ?>
        </div>
    </li>
</ul>