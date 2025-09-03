<?php
/**
 * @package    WT JShopping Add order info to checkout finish
 * @version       1.1.0
 * @Author        Sergey Tolkachyov, https://web-tolk.ru
 * @copyright  Copyright (c) 2025 Sergey Tolkachyov, Sergey Sergevnin. All rights reserved.
 * @license       GNU/GPL3 http://www.gnu.org/licenses/gpl-3.0.html
 * @since         1.0.0
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
