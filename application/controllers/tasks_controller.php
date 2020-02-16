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

        if (isset($_POST['add']))
            $param['add_result'] = $this->model->add_task();

        if (isset($_POST['signin']))
            $param['enter_result'] = $this->model->authorization();

        if (isset($_POST['signout'])) {
            setcookie('login', '', time()-3600);
            setcookie('password', '', time()-3600);
            header('Refresh:1');
        }

        $login = isset($_COOKIE['login']) ? $_COOKIE['login'] : '';
        $password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

        if ((strcasecmp($login, Config::get('admin_login')) == 0) && (strcasecmp($password, md5(Config::get('admin_password'))) == 0))
            $this->view->generate('admin_view.php', 'template_view.php', $data, $param);
        else
            $this->view->generate('tasks_view.php', 'template_view.php', $data, $param);

        $this->model->close_connect();
    }
}