<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="Tools/styless.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<body>
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
            $local_dir = "./" .  $_GET['path'];
            $path = $_GET['path'];

            print "<h2> $path</h2>";

            $files = scandir($local_dir);
            $files = array_diff($files, array('.', '..'));



            foreach ($files as $x => $v) {
                if (is_dir($local_dir . $v)) {
                    echo
                        "<tr>
                        <td>" . '<img src =Nuotraukos/file.svg >' . " " . 'Folder' . "</td>
                      <td>" . '<a href=?path=' . $_GET['path'] . urlencode($v) . '/>' . $v . '</a> ' . "</td>
                      <td></td>
                    </tr>";
                } else {
                    echo
                        "<tr>
                        <td>" . '<img src =Nuotraukos/document.svg >' .  " " . 'File' . "</td>
                        <td>" . $v .  "</td>
                        <td> </td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>





    <form id='makedir' method="post">
        <input type="text" name="pavadinimas">
        <input id="create" name="submit1" type="submit" value="Create">
    </form>


    <?php
    $name = $_POST["pavadinimas"];
    if (isset($_POST["submit1"])) {
        if (!is_dir($local_dir . $name)) {
            mkdir($local_dir . "$name");
            header("Refresh:0");
        }
    }
    echo
        '<a id=back href=?path=' . dirname($_GET['path']) . '/>' . "BACK" . '</a> ';
    ?>






</body>

</html>