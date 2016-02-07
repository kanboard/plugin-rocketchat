<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\RocketChat\Notification\RocketChat;
use Kanboard\Model\Project;
use Kanboard\Model\Task;
use Kanboard\Model\User;
use Kanboard\Model\TaskCreation;
use Kanboard\Model\TaskFinder;

class RocketChatTest extends Base
{
    public function testNotifyUser()
    {
        $this->container['userMetadata']
            ->save(1, array('rocketchat_webhook_url' => 'my url'));

        $this->container['httpClient']
            ->expects($this->once())
            ->method('postForm')
            ->with('my url', $this->anything());

        $userModel = new User($this->container);
        $projectModel = new Project($this->container);
        $taskCreationModel = new TaskCreation($this->container);
        $taskFinderModel = new TaskFinder($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $user = $userModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyUser($user, Task::EVENT_MOVE_COLUMN, $event);
    }

    public function testNotifyUserWithWebhookNotConfigured()
    {
        $this->container['userMetadata']
            ->save(1, array('rocketchat_webhook_url' => ''));

        $this->container['httpClient']
            ->expects($this->never())
            ->method('postForm');

        $userModel = new User($this->container);
        $projectModel = new Project($this->container);
        $taskCreationModel = new TaskCreation($this->container);
        $taskFinderModel = new TaskFinder($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $user = $userModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyUser($user, Task::EVENT_MOVE_COLUMN, $event);
    }

    public function testNotifyProject()
    {
        $this->container['httpClient']
            ->expects($this->once())
            ->method('postForm')
            ->with('my url', $this->anything());

        $userModel = new User($this->container);
        $projectModel = new Project($this->container);
        $taskCreationModel = new TaskCreation($this->container);
        $taskFinderModel = new TaskFinder($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $this->container['projectMetadata']
            ->save(1, array('rocketchat_webhook_url' => 'my url'));

        $project = $projectModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyProject($project, Task::EVENT_MOVE_COLUMN, $event);
    }

    public function testNotifyProjectWithWebhookNotConfigured()
    {
        $this->container['httpClient']
            ->expects($this->never())
            ->method('postForm');

        $userModel = new User($this->container);
        $projectModel = new Project($this->container);
        $taskCreationModel = new TaskCreation($this->container);
        $taskFinderModel = new TaskFinder($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $this->container['projectMetadata']
            ->save(1, array('rocketchat_webhook_url' => ''));

        $project = $projectModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyProject($project, Task::EVENT_MOVE_COLUMN, $event);
    }
}
