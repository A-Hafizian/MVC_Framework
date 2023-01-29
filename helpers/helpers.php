<?php

function site_url ($route){
    return $_ENV['HOST'].$route;
}

function my_varDump($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}
function view($path, $data = [])
{
    extract($data);
    $path = str_replace('.','/',$path);
    include_once BASEPATH."views/$path.php";

}