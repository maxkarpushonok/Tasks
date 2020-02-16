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
<h1>Tasks list - Admin</h1>
<div>
    <div>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" name="signout" value="Sign out">
        </form>
    </div>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
                    $res = ($row['result'] == 1) ? 'checked' : '';
                    echo '<tr><td>' . $row['user']
                        . '</td><td>' . $row['mail']
                        . '</td><td><input id="' . $row['id'] . '" type="text" value="' . $row['task'] . '">' . $edit
                        . '</td><td><input id="'. $row['id'] . '" type="checkbox" ' . $res . '></td></tr>' . "\n";
                }
            }
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="submit" name="save" value="Save"></td>
            </tr>
        </table>
    </form>
</div>
<div>
    <?php /** @var Tasks_Model $param */ echo isset($param['add_result']) ? '<script> alert("' . $param['add_result'] . '");</script>': ''; ?>

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