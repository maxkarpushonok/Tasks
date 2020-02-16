<?php

/**
 * Class Tasks_Model
 */
class Tasks_Model extends Model {
    /**
     * @return int|void
     */
    public function get_page_count() {
        $mysqli = $this->mysqli;

        if ($this->mysqli->connect_error) {
            die('Connection error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $query = "SELECT COUNT(*) FROM `tasks`;";
        $result= $mysqli->query($query);
        $row = $result->fetch_row();
        return (int) ceil($row[0] / Config::get('tasks_on_page'));
    }

    /**
     * @return array|void
     */
    public function get_data() {
        $page = 1;
        if (isset($_GET['p']))
            $page = (int) $_GET['p'];

        $sort = 'user';
        if (isset($_GET['s']))
            $sort = (string) $_GET['s'];

        $way = 'ASC';
        if (isset($_GET['w']))
            $way = (string) $_GET['w'];

        $mysqli = $this->mysqli;

        if ($mysqli->connect_error) {
            die('Connection error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $start = ($page - 1) * Config::get('tasks_on_page');
        $end = Config::get('tasks_on_page');

        $query = "SELECT * FROM tasks ORDER BY $sort $way LIMIT $start, $end;";
        $result = $mysqli->query($query);

        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = array(
                'id' => $row['id'], 'user' => $row['user'], 'mail' => $row['mail'],
                'task' => $row['task'], 'result' => $row['result'],
                'edit' => $row['edit']);
        }

        return $rows;
    }

    private function check_data($str) {
        return htmlspecialchars(stripslashes(trim($str)));
    }

    public function add_task()
    {
        if (empty($_POST['user']) || empty($_POST['mail']) || empty($_POST['task'])) {
            $result = '';

            if (empty($_POST['user']))
                $result .= 'User is empty! ';

            if (empty($_POST['mail']))
                $result .= 'Mail is empty! ';

            if (empty($_POST['task']))
                $result .= 'Task is empty! ';

            return $result;
        } else {
            $user = $this->check_data($_POST['user']);
            $mail = $this->check_data($_POST['mail']);
            $task = $this->check_data($_POST['task']);

            $user_pattern = "/^([A-z]{1,}[ ]{0,1}){1,}$/";
            if (!preg_match($user_pattern, $user))
                return 'User is incorrect!';

//            $mail_pattern = "/^([0-9A-z]{1,}[-._]{0,1}){1,4}@([0-9A-z]{1,}[-]{0,1}[0-9A-z]{1,}\.){1,2}[A-z]{2,}$/";
//            if (!preg_match($mail_pattern, $mail))
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
                return 'Mail is incorrect!';

            $mysqli = $this->mysqli;

            if ($mysqli->connect_error) {
                die('Connection error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
            }

            $query = "INSERT INTO tasks (user, mail, task) VALUES ('" . $user. "', '" . $mail . "', '" . $task. "');";
            $mysqli->query($query);
            header('Refresh:1');
            return 'Task added!';
        }
    }

    public function authorization() {
        if (empty($_POST['login']) || (empty($_POST['password']))) {
            $result = '';

            if (empty($_POST['login']))
                $result .= 'Login is empty! ';

            if (empty($_POST['password']))
                $result .= 'Password is empty!';

            return $result;
        } else {
            $login = $this->check_data($_POST['login']);
            $password = $this->check_data($_POST['password']);

            if (strcasecmp($login, Config::get('admin_login')) != 0)
                return 'Incorrect login!';

            if (strcasecmp($password, Config::get('admin_password')) != 0) {
                return 'Incorrect password!';
            }

            setcookie('login', $login, time()+3600);
            setcookie('password', md5($password), time()+3600);

            header('Refresh:1');
            return 'Authorization!';
        }
    }

    public function checked() {
        $mysqli = $this->mysqli;

        if ($mysqli->connect_error) {
            die('Connection error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $query = "UPDATE tasks SET result=" . $_POST['status'] . " WHERE id=" . $_POST['id'] . ";";
        $mysqli->query($query);
    }
}