<?php

function makeDir()
{


    if (!is_dir($local_dir . $name)) {
        mkdir($local_dir . "/$name");
        header("Refresh:0");
    }
}
