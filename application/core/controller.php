<?php

/**
 * Class Controller
 * Abstract class of controller
 */
class Controller {
    public $model;
    public $view;

    /**
     * Controller constructor.
     */
    function __construct()
    {
        $this->view = new View();
    }

    /**
     * Abstract method
     */
    function action_index() {

    }
}