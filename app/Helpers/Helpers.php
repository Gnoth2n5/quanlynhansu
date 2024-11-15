<?php
function dd($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}

function createSlug($string)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
}

function set_timezone()
{
    date_default_timezone_set($_ENV['TIMEZONE'] ?: 'UTC');
}

function asset($path) {
    global $baseUrl;
    return $baseUrl . ltrim($path, '/');
}