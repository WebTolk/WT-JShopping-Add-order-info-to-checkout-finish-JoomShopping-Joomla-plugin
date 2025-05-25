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

namespace Joomla\Plugin\Jshoppingorder\Wtjshoppingaddorderinfotocheckoutfinish\Fields;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\NoteField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

class PluginshoworderField extends NoteField
{

	protected $type = 'Pluginshoworder';

	/**
	 * Method to get the field input markup for a spacer.
	 * The spacer does not have accept input.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.7.0
	 */
	protected function getInput()
	{

		$data    = $this->form->getData();
		$element = $data->get('element');
		$folder  = $data->get('folder');
		$wa      = Factory::getApplication()->getDocument()->getWebAssetManager();
		$wa->addInlineStyle("
			.plugin-info-img-svg:hover * {
				cursor:pointer;
			}
		");

		$wt_plugin_info = simplexml_load_file(JPATH_SITE . "/plugins/" . $folder . "/" . $element . "/" . $element . ".xml");


		return $html = '<div class="show-info-section">
									<p>Выберите информацию для показа на странице "Спасибо за заказ":</p>
							</div>';
	}

	/**
	 * @return  string  The field label markup.
	 *
	 * @since   1.7.0
	 */
	protected function getLabel()
	{

		return '';
	}

	/**
	 * Method to get the field title.
	 *
	 * @return  string  The field title.
	 *
	 * @since   1.7.0
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}
}
