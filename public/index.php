<!doctype html>
<html lang="en">

<?php

$allowedFiles = ['image/jpeg', 'image/png', 'image/gif'];
$allowedSize = 1048576;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $linkToDelete = 'uploads/' . $_POST['file'];
    if (file_exists($linkToDelete)) {
        unlink($linkToDelete);
    }
    header("Location:");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!empty($_FILES['files']['name'][0])){
        $files = $_FILES['files'];
        foreach ($files['name'] as $position => $file_name) {
            $file_tmp = $files['tmp_name'][$position];
            $file_size = $files['size'][$position];
            $file_type = $files['type'][$position];

            if ($file_size <= $allowedSize) {
                if (in_array($file_type, $allowedFiles)) {
                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                    $filename = 'image' . uniqid() . '.' .$extension;
                    $destination = 'uploads/' . $filename;
                    move_uploaded_file($file_tmp, $destination);
                }
            }
        }
        header("Location:");
        exit();
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laisse pas traîner ton File </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data" class="form-group">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <label for="files">Files:</label>
        <input id="files" type="file" name="files[]" multiple  class="form-control-file"/>
        <input type="submit" value="Send" />
    </form>

    <?php
    $filesUploaded = scandir('uploads');
    ?><div class="card-group"><?php
    foreach ($filesUploaded as $file) {
        $fileLink = 'uploads/' . $file;
        if (in_array(mime_content_type($fileLink), $allowedFiles)) {
            ?><div class="card">
                <img src="<?= $fileLink ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $file ?></h5>
                    <form action="" method="post">
                        <input type="hidden" name="file" value="<?= $file ?>" />
                        <input type="submit" name="delete" value="Delete" />
                    </form>
                </div>
            </div><?php
        }
    }
    ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>

