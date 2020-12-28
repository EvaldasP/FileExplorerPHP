<?php
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
    $msg = '';
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
            <h2>Enter Username and Password</h2>
            <input type="text" name="username" placeholder="username = admin" required autofocus>
            <input type="password" name="password" placeholder="password = 1234" required>
            <button id="loginButton" type="submit" name="login">Login</button>
            <h4><?php echo $msg; ?></h4>
        </form>

    </div>



    <?
    if ($_SESSION['logged_in'] == true){
        
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
        echo " <h5><a style=color:#cb4335 href='index.php?action=logout'>Log Out</a></h5>" ;
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

                $local_dir = "./" .  $_GET['path'];

                $path = $_GET['path'];

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
                        <td><form method='post'><input name='failas' value='$v' type='hidden'>
                        <input id='delete'  name='delete' value='delete' type='submit'></form> </td>
                          </tr>";
                    }
                }

                ?>
            </tbody>
        </table>


        <?php

        // File trinimas ----- 

        if ($_POST['delete']) {
            $file = $_POST['failas'];
            $filokelias = $local_dir . $file;
            if (file_exists($filokelias)) {
                unlink($filokelias);
                header("Refresh:0");
            }
        }




        ?>

        <form id='makedir' method="post">
            <input type="text" name="pavadinimas">
            <input id="create" name="submit1" type="submit" value="Create">
        </form>



        <?php
        //Direktorijos kurimas ----

        $name = $_POST["pavadinimas"];
        if (isset($_POST["submit1"])) {
            if (!is_dir($local_dir . $name)) {
                mkdir($local_dir . "$name");
                header("Refresh:0");
            }
        }

        // Back mygtukas
        echo
            '<a id=back href=?path=' . rawurlencode(dirname($_GET['path'])) . '/>' . "BACK" . '</a> ';
        ?>

    </div>



</body>

</html>