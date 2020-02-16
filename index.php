<?php
#Tasks - Test PHP MVC application

    ini_set('display_errors', 1);

    require_once 'config.php';

    Config::set('tasks_on_page', 3);
    Config::set('db_name', 'tasks');
    Config::set('db_user', 'tasks');
    Config::set('db_pass', 'Qwerty-1');
    Config::set('admin_login', 'admin');
    Config::set('admin_password', '123');

    require_once 'application/bootstrap.php';