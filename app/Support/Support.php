<?php
// Support function here
namespace App\Support;

class Support{
    public static function dd($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die();
    }
}