<?php
/**
 * @package     WT JShopping Add order info to checkout finish
 * * @version     1.0.0
 * * @Author      Sergey Tolkachyov and Sergey Sergevnin, https://web-tolk.ru
 * * @copyright   Copyright (C) 2025 Sergey Tolkachyov and Sergey Sergevnin
 * * @license     GNU/GPL 3.0
 * * @link        https://web-tolk.ru
 * * @since       1.0.0
 */

defined('_JEXEC') or die;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Database\DatabaseInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;
use Joomla\Plugin\Jshoppingorder\Wtjshoppingaddorderinfotocheckoutfinish\Extension\Wtjshoppingaddorderinfotocheckoutfinish;

return new class() implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param Container $container The DI container.
     *
     * @return  void
     *
     * @since   4.0.0
     */
    public function register(Container $container)
    {
        $container->set(
            PluginInterface::class,
            function (Container $container) {
                $subject = $container->get(DispatcherInterface::class);
                $config = (array)PluginHelper::getPlugin('jshoppingorder', 'wtjshoppingaddorderinfotocheckoutfinish');
                $plugin = new Wtjshoppingaddorderinfotocheckoutfinish($subject, $config);
                $plugin->setApplication(Factory::getApplication());
                return $plugin;
            }
        );
    }
};
