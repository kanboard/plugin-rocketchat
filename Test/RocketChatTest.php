<?php

require_once 'tests/units/Base.php';

use Kanboard\Plugin\RocketChat\Notification\RocketChat;
use Kanboard\Model\ProjectModel;
use Kanboard\Model\TaskModel;
use Kanboard\Model\UserModel;
use Kanboard\Model\TaskCreationModel;
use Kanboard\Model\TaskFinderModel;

class RocketChatTest extends Base
{
    public function testNotifyUser()
    {
        $this->container['userMetadataModel']
            ->save(1, array('rocketchat_webhook_url' => 'my url'));

        $this->container['httpClient']
            ->expects($this->once())
            ->method('postJsonAsync')
            ->with('my url', $this->anything());

        $userModel = new UserModel($this->container);
        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $user = $userModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyUser($user, TaskModel::EVENT_MOVE_COLUMN, $event);
    }

    public function testNotifyUserWithWebhookNotConfigured()
    {
        $this->container['userMetadataModel']
            ->save(1, array('rocketchat_webhook_url' => ''));

        $this->container['httpClient']
            ->expects($this->never())
            ->method('postJsonAsync');

        $userModel = new UserModel($this->container);
        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $user = $userModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyUser($user, TaskModel::EVENT_MOVE_COLUMN, $event);
    }

    public function testNotifyProject()
    {
        $this->container['httpClient']
            ->expects($this->once())
            ->method('postJsonAsync')
            ->with('my url', $this->anything());

        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $this->container['projectMetadataModel']
            ->save(1, array('rocketchat_webhook_url' => 'my url'));

        $project = $projectModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyProject($project, TaskModel::EVENT_MOVE_COLUMN, $event);
    }

    public function testNotifyProjectWithWebhookNotConfigured()
    {
        $this->container['httpClient']
            ->expects($this->never())
            ->method('postJsonAsync');

        $projectModel = new ProjectModel($this->container);
        $taskCreationModel = new TaskCreationModel($this->container);
        $taskFinderModel = new TaskFinderModel($this->container);
        $handler = new RocketChat($this->container);

        $this->assertEquals(1, $projectModel->create(array('name' => 'test')));
        $this->assertEquals(1, $taskCreationModel->create(array('project_id' => 1, 'title' => 'test')));

        $this->container['projectMetadataModel']
            ->save(1, array('rocketchat_webhook_url' => ''));

        $project = $projectModel->getById(1);
        $task = $taskFinderModel->getDetails(1);
        $event = array('task' => $task);
        $event['task']['task_id'] = $task['id'];

        $handler->notifyProject($project, TaskModel::EVENT_MOVE_COLUMN, $event);
    }
}
