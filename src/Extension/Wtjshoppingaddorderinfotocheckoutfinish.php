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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Component\Jshopping\Site\Helper\Helper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use Joomla\Component\SWJProjects\Site\Helper\RouteHelper;

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
        $order->shipping_params_data = 'a:6:{s:16:"sm_wtcdek_pvz_id";s:4:"MGD1";s:18:"sm_wtcdek_pvz_city";s:60:"Магадан, городской округ Магадан";s:14:"sm_wtcdek_addr";s:27:"ул. Кольцевая, 3";s:14:"sm_wtcdek_type";s:23:"пункт выдачи";s:24:"sm_wtcdek_delivery_times";s:38:"Срок доставки 5-5 дней";s:19:"sm_wtcdek_work_time";s:44:"Пн-Пт 10:00-19:00, Сб-Вс 10:00-16:00";}';
        $sh_params = unserialize($order->shipping_params_data);

        $order->setShippingParamsData($sh_params);
        $order->getAllItems();
        $user_info = JSFactory::getUser();


        /**
         * $order->getShipping()->getShippingForm()->getDisplayNameParams();
         */
        $sh_method = JSFactory::getTable('shippingMethod');
        $sh_method->load($order->shipping_method_id); //  или как оно там
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
