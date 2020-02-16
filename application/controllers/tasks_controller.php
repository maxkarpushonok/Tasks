<?php

/**
 * Class Tasks_Controller
 */
class Tasks_Controller extends Controller
{
    /**
     * Tasks_Controller constructor.
     */
    function __construct()
    {
        $this->model = new Tasks_Model();
        $this->view = new View();
    }

    /**
     * Set data and params
     * Call generate pages method
     */
    function action_index()
    {
        $data = $this->model->get_data();
        $param['pages'] = $this->model->get_page_count();
        $this->view->generate('tasks_view.php', 'template_view.php', $data, $param);
    }
}