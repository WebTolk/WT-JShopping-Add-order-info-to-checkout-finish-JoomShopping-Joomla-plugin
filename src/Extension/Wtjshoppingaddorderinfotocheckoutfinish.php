<?php
/**
 * @package    WT JShopping Add order info to checkout finish
 * @version       1.1.0
 * @Author        Sergey Tolkachyov, https://web-tolk.ru
 * @copyright  Copyright (c) 2025 Sergey Tolkachyov, Sergey Sergevnin. All rights reserved.
 * @license       GNU/GPL3 http://www.gnu.org/licenses/gpl-3.0.html
 * @since         1.0.0
 */

namespace Joomla\Plugin\Jshoppingorder\Wtjshoppingaddorderinfotocheckoutfinish\Extension;

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Component\Jshopping\Site\Helper\Helper;
use Joomla\Component\Jshopping\Site\Lib\JSFactory;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;

use function defined;

// No direct access
defined('_JEXEC') or die;

class Wtjshoppingaddorderinfotocheckoutfinish extends CMSPlugin implements SubscriberInterface
{
    protected $autoloadLanguage = true;

    /**
     * Returns an array of events this subscriber will listen to.
     *
     * @return  array
     *
     * @since   1.0.0
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onBeforeDisplayCheckoutFinish' => 'onBeforeDisplayCheckoutFinish',
        ];
    }

    /**
     * Trigger fired on \Joomla\Component\Jshopping\Site\Controller\CheckoutController::finish
     *
     * @param   Event  $event
     *
     * @return void
     * @see   \Joomla\Component\Jshopping\Site\Controller\CheckoutController::finish
     * @since 1.0.0
     */

    public function onBeforeDisplayCheckoutFinish(Event $event): void
    {
        /**
         * @var string $eventArguments[0] - $text     статический текст для страницы Завершения заказа из настроек JoomShopping
         * @var int    $eventArguments[1] - $order_id id заказа
         * @var string $eventArguments[2] - $text_end Текст в самом конце. JoomShopping 5.3.1+
         */
        //
        $eventArguments = $event->getArguments();
        $order_id = $eventArguments[1];
        $order = JSFactory::getTable('order');
        $order->load($order_id);
        $order->getAllItems();
        $user_info = JSFactory::getUser();
        $sh_method = JSFactory::getTable('shippingMethod');
        $sh_method->load($order->shipping_method_id);

        if ($shippingForm = $sh_method->getShippingForm())
        {
            $sh_params = $order->getShippingParamsData();
            $shippingForm->setParams($sh_params);
            $shipping_params_names = $shippingForm->getDisplayNameParams();
            $order->shipping_params = Helper::getTextNameArrayValue( $shipping_params_names, $sh_params);
            $order->wtjshoppingaddorderinfotocheckoutfinish_shipping_params_names = $shipping_params_names;
        }

        $checkout_finish_position = $this->params->get('checkout_finish_position','text');
        $mode = $this->params->get('mode','before');

        $html = $this->getHtml($order, $user_info);

        /** @var int $event_argument_position 0 - Для аргумента `$text` */
        $event_argument_position = $checkout_finish_position == 'text' ? 0 : 2;

        switch ($mode) {
            case 'replace':
                $eventArguments[$event_argument_position] = $html;
                break;
            case 'after':
                $eventArguments[$event_argument_position] .= $html;
                break;
            case 'before':
            default:
                $eventArguments[$event_argument_position] = $html.$eventArguments[$event_argument_position];
                break;
        }
    }

    /**
     * Render HTML layout for order info
     *
     * @param $order
     * @param $user_info
     *
     * @return string
     *
     * @since 1.0.0
     */
    protected function getHtml($order, $user_info): string
    {
        $layoutPath = JPATH_PLUGINS . '/' . $this->_type . '/' . $this->_name . '/tmpl';

        $tmpl = $this->params->get('tmpl', 'default');

        if (!is_file($layoutPath . '/' . $tmpl . '.php'))
        {
            $tmpl = 'default';
        }

        $html = LayoutHelper::render(
            $tmpl,
            [
                'order'     => $order,
                'user_info' => $user_info,
                'params'    => $this->params,

            ],
            $layoutPath
        );

        return $html;
    }
}
