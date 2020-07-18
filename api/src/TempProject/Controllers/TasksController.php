<?php

namespace TempProject\Controllers;

use TempProject\Models\Tasks\Task;
use TempProject\Models\Users\User;
use TempProject\Services\Db;
use TempProject\View\View;

class TasksController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        
    }

    public function view(int $taskId)
    {
        $task = Task::getById($taskId);
        if ($article === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $this->view->renderHtml('task/view.php', [
            'task' => $task
        ]);


    }

    public function getTasks(int $page, string $order, string $orderBy) {
        $tasks = Task::findAll($page, $order, $orderBy);
        $this->view->renderHtml('main/main.php', ['tasks' => $tasks]);
    }

    public function edit($username, $text, $email, $id, $isModered)
    {
        $task = Task::getByString($id, "id");

        if ($task === null) {
            $this->view->renderHtml('errors/404.php', [], 404);
            return;
        }

        $task->setUserName($username);
        $task->setText($text);
        $task->setEmail($email);
        $task->setIsModered($isModered === "0" ? false : true );
        $task->setIsEdited(true);

        $status = $task->save();
        $this->view->renderHtml('main/success.php', ['status' => $status]);

    }


    public function add($username, $text, $email)
    {
        $task = new Task();
        $task->setUserName($username);
        $task->setEmail($email);
        $task->setText($text);
        $task->setIsModered(false);
        $task->setIsEdited(false);
        
        $status = $task->save();
        $this->view->renderHtml('main/success.php', ['status' => $status]);
        
    }

}