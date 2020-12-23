<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        img {
            transform: translateY(5px);
            width: 24px;
        }
    </style>


    <?php
    $local_dir = './';


    $files = scandir($local_dir);
    $files = array_diff($files, array('.', '..'));

    print_r($files);
    print "<h2> Failu Narsykle </h2>  ";
    print " ------------------------ <br>";
    print "<br>";
    foreach ($files as $x => $v) {
        if (is_dir($v)) {
            print "<img src= Nuotraukos/file.svg  > " . "<a href='$local_dir/$v'> $v</a> " . "<br>";
        } else {
            print "<img src= Nuotraukos/folder.svg >" .  $v . "<br>";
        }
    }





    ?>

</body>

</html>