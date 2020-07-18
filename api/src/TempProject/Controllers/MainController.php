<?php
namespace TempProject\Controllers;

use TempProject\Models\Tasks\Task;
use TempProject\Models\Users\User;
use TempProject\View\View;
use TempProject\Services\Db;


class MainController {

    /** @var View */
    private $view;

    /** @var Db */
    private $db;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
        $this->db = Db::getInstance();
    }

    public function main()
    {
        echo "Please insert request.";
    }

    public function getUser(string $login) {
        $user = User::getByString($login, "username");
        $this->view->renderHtml('main/user.php', ['user' => $user]);
    }

    public function about() {
        $info = "About infooo";

        $this->view->renderHtml('main/about.php', ['info' => $info]);
    }

    public function sayHello(string $name)
    {
        $this->view->renderHtml('main/hello.php', ['name' => $name]);
    }
}


?>