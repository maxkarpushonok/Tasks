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
            $user = trim($_POST['user']);
            $mail = trim($_POST['mail']);
            $task = htmlspecialchars(stripslashes(trim($_POST['task'])));

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
            header('Refresh:3');
            return 'Task added!';
        }

    }
}