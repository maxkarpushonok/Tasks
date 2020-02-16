<?php
    /**
     * Default action
     */
    include 'application/controllers/tasks_controller.php';
    include 'application/models/tasks_model.php';
    $controller = new Tasks_Controller();
    $controller->action_index();

//TODO routing