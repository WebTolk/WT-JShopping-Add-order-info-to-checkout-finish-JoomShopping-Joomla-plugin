<?php

/**
 * @package     WT JShopping Add order info to checkout finish
 * @version     1.0.0
 * @Author      Sergey Tolkachyov and Sergey Sergevnin, https://web-tolk.ru
 * @copyright   Copyright (C) 2025 Sergey Tolkachyov and Sergey Sergevnin
 * @license     GNU/GPL 3.0
 * @link        https://web-tolk.ru
 * @since       1.0.0
 */

namespace Joomla\Plugin\Jshoppingorder\Wtjshoppingaddorderinfotocheckoutfinish\Extension;

// No direct access
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Language\Text;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Component\Jshopping\Site\Helper\Helper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;


class Wtjshoppingaddorderinfotocheckoutfinish extends CMSPlugin implements SubscriberInterface
{
    protected $autoloadLanguage = true;

    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   4.0.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onBeforeDisplayCheckoutFinish' => 'onBeforeDisplayCheckoutFinish',
        ];
    }

    /**
     *
     * @param $view
     *
     *
     * @since 1.0.0
     */

    public function onBeforeDisplayCheckoutFinish(Event $event): void
    {
        /**
         * @var string $text статический текст для страницы Завершения заказа из настроек JoomShopping
         * @var int $order_id id заказа
         */
        [$text, $order_id, $text_end] = $event->getArguments();

        $order = JSFactory::getTable('order', 'jshop');
        $order->load($order_id);
        $order->getAllItems();

        $user_info = JSFactory::getUser();

        $sh_method = JSFactory::getTable('shippingMethod');
        $sh_method->load($order->shipping_method_id);
        $shippingForm = $sh_method->getShippingForm('sm_wtcdek_form');

        if ($shippingForm) {
            $shippingForm->setParams($sh_params);
            $shipping_params_names = $shippingForm->getDisplayNameParams();
            $order->shipping_params = Helper::getTextNameArrayValue($shipping_params_names, $sh_params);
            $order->wtjshoppingaddorderinfotocheckoutfinish_shipping_params_names = $shipping_params_names;
        }

        $text = $this->getHtml($order, $user_info);

        $event->setArgument(0, $text);
    }

    protected function getHtml($order, $user_info): string
    {
        $layoutPath = JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/tmpl';

        $tmpl = $this->params->get('tmpl', 'default');

        if (!is_file($layoutPath . '/' . $tmpl . '.php')) {
            $tmpl = 'default';
        }

        $html = LayoutHelper::render(
            $tmpl,
            [
                'order' => $order,
                'user_info' => $user_info,
                'params' => $this->params,

            ],
            $layoutPath
        );
        return $html;
    }
}
