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
<h1>Список задач - Управление задачами</h1>
<div>
    <div>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) . '?p=' . $page . '&s=' . $sort . '&w=' . $way;?>" method="post">
            <input type="submit" name="signout" value="Выйти">
        </form>
    </div>
    <script>
        function getXmlHttp(){
            var xmlhttp;
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xmlhttp = false;
                }
            }
            if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }

        function submit_checkbox(e) {
            const req = getXmlHttp();
            const id = e.id;
            const status = e.checked;
            const url = '/index.php';
            const params = 'checked=true&id=' + id + '&status=' + status;

            req.open('POST', url, true);

            req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            req.addEventListener('readystatechange', () => {
                if(req.readyState === 4 && req.status === 200) {
                    alert('Изменения сохранены!');
                }
            });

            req.send(params);
        }
    </script>
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <table>
            <tr>
                <td><a href="<?='?p=' . $page . '&s=user&w=' . $way_i . ''?>">имя пользователя</a></td>
                <td><a href="<?='?p=' . $page . '&s=mail&w=' . $way_i . ''?>">e-mail</a></td>
                <td>текст задачи</td>
                <td><a href="<?='?p=' . $page . '&s=result&w=' . $way_i . ''?>">статус</a></td>
            </tr>
<?php
    /** @var Tasks_Model $data */
    if ($data != NULL) {
        foreach ($data as $row) {
            $edit = '';
            if ($row['edit'])
                $edit = '<br/><span style="color: #900;">Отредактировано администратором.</span>';
            $res = ($row['result'] == 1) ? 'checked' : '';
            echo '<tr><td>' . $row['user']
                . '</td><td>' . $row['mail']
                . '</td><td><input id="' . $row['id'] . '" type="text" name="task[' . $row['id'] . ']" value="' . $row['task'] . '">' . $edit
                . '</td><td><input id="' . $row['id']  . '" type="checkbox" name="result[]" ' . $res . ' onchange="submit_checkbox(this)"></td></tr>' . "\n";
        }
    }
?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><input type="submit" name="save" value="Сохранить"></td>
            </tr>
        </table>
    </form>
</div>
<div>
    <?php /** @var Tasks_Model $param */ echo isset($param['save_result']) ? '<script> alert("' . $param['save_result'] . '");</script>': ''; ?>

</div>
<div>
    <?php
    /** @var Tasks_Model $param */
    if ($param['pages'] > 1) {
        echo 'Страницы: ';
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