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
    <script>
        function hideShow() {
            var x = document.getElementById("authorization");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <div>
        <div>
            <button onclick="hideShow()">Authorization</button>
            <div id="authorization" style="display: none">
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="post">
                    <input type="text" name="login" placeholder="Login" value="<?= isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>" required><br/>
                    <input type="password" name="password" placeholder="Password" value="<?= isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>" required><br/>
                    <input type="submit" name="signin" value="Sign in">
                </form>
                <?php /** @var Tasks_Model $param */ echo isset($param['enter_result']) ? '<script> alert("' . $param['enter_result'] . '");</script>': ''; ?>
            </div>
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
            $res = ($row['result'] == 1) ? 'Ok' : 'No';
            echo '<tr><td>' . $row['user']
                . '</td><td>' . $row['mail']
                . '</td><td>' . $row['task'] . $edit
                . '</td><td>' . $res . '</td></tr>' . "\n";
        }
    }
?>
            <tr>
                <td><input type="text" name="user" placeholder="Name" value="<?= isset($_POST['user']) ? htmlspecialchars($_POST['user']) : '';?>" required></td>
                <td><input type="email" name="mail" placeholder="e-mail" value="<?= isset($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';?>" required></td>
                <td><input type="text" name="task" placeholder="task" value="<?= isset($_POST['task']) ? htmlspecialchars($_POST['task']) : '';?>" required></td>
                <td><input type="submit" name="add" value="Add task"></td>
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