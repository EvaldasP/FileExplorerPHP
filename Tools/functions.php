<?php

function addfile()
{
    $errors = array();
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
    $extensions = array("jpeg", "jpg", "png", "txt");
    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG, a TXT or PNG file.";
    }
    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }
    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, $_GET['path'] . $file_name);
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        print_r($errors);
    }
}


function downloandFile()
{
    $file = $_GET['path'] . $_POST['fileDownload'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped));
    ob_end_flush();
    readfile($fileToDownloadEscaped);
    exit;
}



function makeDir()
{
    $path = "./" .  $_GET['path'];
    $name = $_POST["pavadinimas"];
    if (isset($_POST["submit1"])) {
        if (!is_dir($path . $name)) {
            mkdir($path . "$name");
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
}


function deleteFile()

{
    $file = $_POST['failas'];
    $path = "./" .  $_GET['path'];
    $filokelias = $path . $file;
    if (file_exists($filokelias)) {
        unlink($filokelias);
        echo "<meta http-equiv='refresh' content='0'>";
    }
}
