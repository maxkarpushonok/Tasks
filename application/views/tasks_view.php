<?php
$page = 1;
if (isset($_GET['p']))
    $page = (int) $_GET['p'];

$sort = 'user';
if (isset($_GET['s']))
    $sort = (string) $_GET['s'];

$way = 'ASC';
if (isset($_GET['w']))
    $way = (string) $_GET['w'];

$way_i = ((strcasecmp($way, 'ASC') == 0) ? 'DESC' : 'ASC');
?>
    <h1>Tasks list</h1>
    <div>
        <table>
            <tr>
                <td><a href="<?='?p=' . $page . '&s=user&w=' . $way_i . ''?>">User</a></td>
                <td><a href="<?='?p=' . $page . '&s=mail&w=' . $way_i . ''?>">Mail</a></td>
                <td>Task</td>
                <td><a href="<?='?p=' . $page . '&s=result&w=' . $way_i . ''?>">Result</a></td>
            </tr>
            <?php
            /** @var Tasks_Model $data */
            if ($data != NULL) {
                foreach ($data as $row) {
                    $edit = '';
                    if ($row['edit'])
                        $edit = '</br>Edited by admin';
                    $res = ($row['result'] == 1) ? 'Ok' : 'No';
                    echo '<tr><td>' . $row['user']
                        . '</td><td>' . $row['mail']
                        . '</td><td>' . $row['task'] . $edit
                        . '</td><td>' . $res . '</td></tr>' . "\n";
                }
            }
            ?>
            <form action="" method="post">
                <tr>
                    <td><input id="user" type="text" name="user" placeholder="Name"></td>
                    <td><input id="mail" type="email" name="mail" placeholder="e-mail"></td>
                    <td><input id="task" type="text" name="task" placeholder="task"></td>
                    <td><input id="add" type="submit" name="add" value="Add task"></td>
                </tr>
            </form>
        </table>
    </div>
    <div>
        <?php
        /** @var Tasks_Model $param */
        if ($param['pages'] > 1) {
            echo 'Pages: ';
            for ($i = 1; $i <= $param['pages']; $i++) {
                if ($i == $page)
                    echo $i;
                else
                    echo '<a href="?p=' . $i . '&s=' . $sort . '&w=' . $way . '">' . $i . '</a>';
                if ($i != $param['pages'])
                    echo ', ';
            }
        }
        ?>
    </div>
<?php
echo var_dump($_POST); //TODO debug