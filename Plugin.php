<?php

namespace Kanboard\Plugin\RocketChat;

use Kanboard\Core\Translator;
use Kanboard\Core\Plugin\Base;

/**
 * RocketChat Plugin
 *
 * @package  slack
 * @author   Frederic Guillot
 */
class Plugin extends Base
{
    public function initialize()
    {
        $this->template->hook->attach('template:project:integrations', 'RocketChat:project/integration');
        $this->template->hook->attach('template:user:integrations', 'RocketChat:user/integration');

        $this->userNotificationType->setType('rocketchat', 'RocketChat', '\Kanboard\Plugin\RocketChat\Notification\RocketChat');
        $this->projectNotificationType->setType('rocketchat', 'RocketChat', '\Kanboard\Plugin\RocketChat\Notification\RocketChat');

        $this->on('app.bootstrap', function ($container) {
            Translator::load($container['config']->getCurrentLanguage(), __DIR__.'/Locale');
        });
    }

    public function getPluginDescription()
    {
        return 'Receive notifications on RocketChat';
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-rocketchat';
    }
}
