<?php

/**
 * @package     WT JShopping Add order info to checkout finish
 * @version     1.0.0
 * @Author      Sergey Tolkachyov, https://web-tolk.ru
 * @copyright   Copyright (C) 2025 Sergey Tolkachyov
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
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use Joomla\Component\SWJProjects\Site\Helper\RouteHelper;

class Wtjshoppingaddorderinfotocheckoutfinish extends CMSPlugin implements SubscriberInterface
{
	use DatabaseAwareTrait;

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
		 * @var string $text     статический текст для страницы Завершения заказа из настроек JoomShopping
		 * @var int    $order_id id заказа
		 */
		[$text, $order_id, $text_end] = $event->getArguments();

		$order = JSFactory::getTable('order', 'jshop');
		$order->load($order_id);
		$order->getAllItems();
		$jshopping_extra_field_id = $this->params->get("jshopping_extra_field_id");
		$show_keys_on_checkout    = $this->params->get("show_key_info_on_checkout_finish");

		$user_info = JSFactory::getUser();
		$user_id   = (int) $user_info->user_id;

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

		$html  = LayoutHelper::render(
			$tmpl,
			[
				'order' => $order,
				'user_info'    => $user_info,
				'params'   => $this->params,
			],
			$layoutPath
		);
		return $html;
	}
}
