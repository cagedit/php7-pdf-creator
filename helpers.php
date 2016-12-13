<?php
function rootDir(string $suffix)
{
    return __ROOT__ . '/' . $suffix;
}

function dd()
{
    $variables = func_get_args();

    echo '<pre>';
    foreach ($variables as $variable) {
        var_dump($variable);
    }
    die('</pre>');
}