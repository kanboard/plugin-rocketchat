<?php

namespace Kanboard\Plugin\RocketChat\Notification;

use Kanboard\Core\Base;
use Kanboard\Notification\NotificationInterface;

/**
 * RocketChat Notification
 *
 * @package  notification
 * @author   Frederic Guillot
 */
class RocketChat extends Base implements NotificationInterface
{
    /**
     * Send notification to a user
     *
     * @access public
     * @param  array     $user
     * @param  string    $event_name
     * @param  array     $event_data
     */
    public function notifyUser(array $user, $event_name, array $event_data)
    {
        $webhook = $this->userMetadata->get($user['id'], 'rocketchat_webhook_url');

        if (! empty($webhook)) {
            $project = $this->project->getById($event_data['task']['project_id']);
            $this->sendMessage($webhook, $project, $event_name, $event_data);
        }
    }

    /**
     * Send notification to a project
     *
     * @access public
     * @param  array     $project
     * @param  string    $event_name
     * @param  array     $event_data
     */
    public function notifyProject(array $project, $event_name, array $event_data)
    {
        $webhook = $this->projectMetadata->get($project['id'], 'rocketchat_webhook_url');

        if (! empty($webhook)) {
            $this->sendMessage($webhook, $project, $event_name, $event_data);
        }
    }

    /**
     * Get message to send
     *
     * @access public
     * @param  array     $project
     * @param  string    $event_name
     * @param  array     $event_data
     */
    public function getMessage(array $project, $event_name, array $event_data)
    {
        if ($this->userSession->isLogged()) {
            $author = $this->helper->user->getFullname();
            $title = $this->notification->getTitleWithAuthor($author, $event_name, $event_data);
        } else {
            $title = $this->notification->getTitleWithoutAuthor($event_name, $event_data);
        }

        $message = '*['.$project['name'].']* ';
        $message .= $title;
        $message .= ' ('.$event_data['task']['title'].')';

        if ($this->config->get('application_url') !== '') {
            $message .= ' - <';
            $message .= $this->helper->url->to('task', 'show', array('task_id' => $event_data['task']['id'], 'project_id' => $project['id']), '', true);
            $message .= '|'.t('view the task on Kanboard').'>';
        }

        return array(
            'text' => $message,
            'username' => 'Kanboard',
            'icon_url' => 'http://kanboard.net/assets/img/favicon.png',
        );
    }

    /**
     * Send message to RocketChat
     *
     * @access private
     * @param  srting    $webhook
     * @param  array     $project
     * @param  string    $event_name
     * @param  array     $event_data
     */
    private function sendMessage($webhook, array $project, $event_name, array $event_data)
    {
        $payload = $this->getMessage($project, $event_name, $event_data);
        $this->httpClient->postForm($webhook, $payload);
    }
}
