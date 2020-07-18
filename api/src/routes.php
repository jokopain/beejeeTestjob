<?php

return [
    '~^task/get/(\d+)/(.*)/(.*)$~' => [\TempProject\Controllers\TasksController::class, 'getTasks'],
    '~^user/get/(.*)$~' => [\TempProject\Controllers\MainController::class, 'getUser'],
    '~^task/edit/~' => [\TempProject\Controllers\TasksController::class, 'edit'],
    '~^task/add/~' => [\TempProject\Controllers\TasksController::class, 'add'],
    '~^$~' => [\TempProject\Controllers\MainController::class, 'main'],
];

?>