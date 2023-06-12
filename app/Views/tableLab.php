<html>

<head>
    <title><?= esc($title) ?></title>
</head>

<body>
    <h1><?= esc($heading) ?></h1>
    
    <table>
        <thead>
            <tr>
                <th>Time Used</th>
                <th>Step</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($todo_list as $key => $value) : ?>
                <tr>
                    <td><?= esc($key) ?></td>
                    <?php foreach ($value as $weekWork) : ?>

                        <td><?= esc($weekWork) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>