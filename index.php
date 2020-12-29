<?php
include './Tools/functions.php';
session_start();
// logout logic
if (isset($_GET['action']) and $_GET['action'] == 'logout') {
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="Tools/styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <?php

    //Funkcijos aprasytos Tools/functions.php 

    if ($_SESSION['logged_in'] == true) {

        // Failo parsiuntimas
        if (isset($_POST['download'])) {
            downloandFile();
        }

        // Direktorijos sukurimas
        if (isset($_POST["submit1"])) {
            makeDir();
        }

        // Failo pridejimas
        if (isset($_FILES['file'])) {
            addfile();
        }

        // Failo istrinimas
        if ($_POST['delete']) {
            deleteFile();
        }
    }
    ?>


    <?php

    if (
        isset($_POST['login'])
        && !empty($_POST['username'])
        && !empty($_POST['password'])
    ) {
        if (
            $_POST['username'] == 'admin' &&
            $_POST['password'] == '1234'
        ) {
            $_SESSION['logged_in'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'admin';
        } else {
            $msg = 'Wrong username or password';
        }
    }
    ?>


    <div id="login">
        <form action="./index.php" method="post">
            <img style=width:100px src="Nuotraukos/explorer.svg" alt="">
            <h1 style="color: #2e86c1;" class="Title">File Explorer PHP</h1>
            <h2>Please Log In</h2>
            <input type="text" name="username" placeholder="username = admin" required autofocus>
            <input type="password" name="password" placeholder="password = 1234" required>
            <button id="loginButton" type="submit" name="login">Login</button>
            <h4><?php echo $msg; ?></h4>
        </form>
    </div>



    <?php

    // Logika kuri prisijungus parodo contenta ir paslepia logino forma

    if ($_SESSION['logged_in'] == true) {
        echo '<style type="text/css">
        #wrapper {
            display: block;
        }
        #login {
            display:none;
        }
        </style>';

        $hello = 'Hello' . ', ' .   $_SESSION['username'];
        echo "<h4 style=color:#52be80> $hello  </h4>";
        echo " <h5><a style=color:#cb4335 href='index.php?action=logout'>Log Out</a></h5>";
    }

    ?>



    <div id="wrapper">
        <div class="intro">
            <img src="Nuotraukos/explorer.svg" alt="">
            <h1 class="Title">File Explorer PHP</h1>
        </div>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">Name</th>
                    <th scope="col">Action</th>

                </tr>
            </thead>
            <tbody>

                <?php

                // Direktorijos skaitymas ir atvaizdavimas

                if ($_SESSION['logged_in'] == true) {
                    $local_dir = "./" .  $_GET['path'];

                    $path =  $_GET['path'];

                    print "<h2> $path </h2>";

                    $files = scandir($local_dir);
                    $files = array_diff($files, array('.', '..'));
                    foreach ($files as $x => $v) {
                        if (is_dir($local_dir . $v)) {
                            echo
                                "<tr>
                            <td>" . '<img src =Nuotraukos/file.svg >' . " " . 'Folder' . "</td>
                            <td>" . '<a href=?path=' . rawurlencode($_GET['path']) . rawurlencode($v) . '/>' . $v . '</a> ' . "</td>
                            <td></td>
                                 </tr>";
                        } else {
                            echo
                                "<tr>
                        <td>" . '<img src =Nuotraukos/document.svg >' .  " " . 'File' . "</td>
                        <td>" . $v .  "</td>
                        <td id = actions><form method='post'><input name='failas' value='$v' type='hidden'>
                        <input id='delete'  name='delete' value='delete' type='submit'></form> 
                        
                        <form id=dalykas method='post'>
                        <input name='fileDownload' value='$v' type='hidden'>
                        <input id =downloadButton name='download' value='download' type='submit'>
                        </form> </td>
                          </tr>";
                        }
                    }
                }

                ?>
            </tbody>
        </table>

        <div id="bottom">
            <form id='makedir' method="post">
                <input type="text" name="pavadinimas">
                <input id="create" name="submit1" type="submit" value="Create">
            </form>
            <form id="uploadFile" action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="file" />
                <input id="uploadButton" type="submit" value="Upload" />
            </form>
        </div>

        <?php

        // Back mygtukas
        if ($_SESSION['logged_in'] == true) {
            echo
                '<a id=back href=?path=' . rawurlencode(dirname($_GET['path'])) . '/>' . "BACK" . '</a> ';
        }
        ?>
    </div>
</body>

</html>