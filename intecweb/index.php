<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Тестовое задание INTEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .form-csv {
            max-width: 330px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="text-center">
    <form class="form-csv" action="csvForm.php" method="post" enctype="multipart/form-data" >
        <div class="my-3">
            <label class="form-label" for="importFile">Выберите файл для импорта</label>
            <input type="file" class="form-control" id="importFile" name="importFile" required/>
        </div>
        <button type="submit" class="btn btn-primary" name="import">Импорт</button>
        <button type="submit" class="btn btn-primary" name="export" formnovalidate>Экспорт</button>
    </form>
</body>
</html>