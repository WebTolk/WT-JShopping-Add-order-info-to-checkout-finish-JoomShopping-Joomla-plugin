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


\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.collapse', '.selector', []);

/** @var array $displayData */

extract($displayData);

/**
 * @var string $filePath Path to PDF file
 * @var bool $first Is this first iteration or not?
 * @var Joomla\Registry\Registry|null $params The plugin params
 */
$order->shipping_params_data = 'a:6:{s:16:"sm_wtcdek_pvz_id";s:4:"MGD1";s:18:"sm_wtcdek_pvz_city";s:60:"Магадан, городской округ Магадан";s:14:"sm_wtcdek_addr";s:27:"ул. Кольцевая, 3";s:14:"sm_wtcdek_type";s:23:"пункт выдачи";s:24:"sm_wtcdek_delivery_times";s:38:"Срок доставки 5-5 дней";s:19:"sm_wtcdek_work_time";s:44:"Пн-Пт 10:00-19:00, Сб-Вс 10:00-16:00";}'
?>
<div class="d-flex card border border-success mb-4">
    <div class="card-body text-center">
        <div class="icon-row">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="100px" height="100px" viewBox="0 0 24 24"
                 id="check-mark-circle" data-name="Line Color" class="icon line-color">
                <polyline id="secondary" points="8 11.5 11 14.5 16 9.5"
                          style="fill: none; stroke: rgb(25, 135, 84); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
                <rect id="primary" x="3" y="3" width="18" height="18" rx="9"
                      style="fill: none; stroke: rgb(25, 135, 84); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"/>
            </svg>
        </div>
        <div class="text-row">
            <h2><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_TMPL_THANK_TITLE') ?></h2>
            <p class="fs-3"><?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_TMPL_THANK_TEXT') ?></p>
            <p class="fs-3 fw-bold">
                <span class="order-info-label"><?php echo Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_ORDER_NUMBER'); ?></span>:
                <span
                        class="order-info-value"><?php echo $order->order_number; ?></span></p>
        </div>
    </div>
</div>
<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed fs-5 fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                <?php print Text::_(string: 'PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_TMPL_ORDER_DETAILS_LABEL') ?>
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
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
                    <p><span class="order-info-label"><?php echo Text::_('JSHOP_FINISH_PAYMENT_METHOD'); ?></span>:
                        <span
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
                    <p><span class="order-info-label"><?php echo Text::_('JSHOP_FINISH_SHIPPING_METHOD'); ?></span>:
                        <span
                                class="order-info-value"><?php echo $order->getShippingName(); ?></span></p>
                <?php endif; ?>

                <?php
                if (!empty((float)$order->order_shipping) && $params->get('show_order_shipping_price', false) == true) : ?>
                    <p><span class="order-info-label"><?php echo Text::_('JSHOP_SHIPPING_PRICE'); ?></span>: <span
                                class="order-info-value"><?php echo $order->order_shipping; ?></span></p>
                <?php endif; ?>

                <?php
                if (!empty($shipping_params_data = $order->getShippingParamsData()) && $params->get('show_order_shipping_params_data', false) == true) : ?>
                    <p>
                        <span class="order-info-label"><?php echo Text::_('PLG_WTJSHOPPINGADDORDERINFOTOCHECKOUTFINISH_SHOW_SHIPPING_PARAMS_DATA'); ?></span>
                    </p>
                    <?php
                    foreach ($shipping_params_data as $key => $value): ?>
                        <p><span><?php echo $key; ?> </span> <span><?php echo $value; ?> </span></p>
                    <?php
                    endforeach;
                endif;
                ?>

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
            </div>
        </div>
    </div>
</div>