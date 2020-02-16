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
        $end = $start + Config::get('tasks_on_page');

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
}