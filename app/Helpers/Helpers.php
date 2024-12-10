<?php
use voku\helper\ASCII;

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

function start_session()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function createUID($full_name, $dob)
{
    // xoá dấu
    $fullName = ASCII::to_ascii($full_name);
    
    // tách họ và tên và lưu vào mảng
    $nameParts = explode(' ', $fullName);
    
    // lấy tên chính
    $lastName = array_pop($nameParts);

    $initials = '';
    foreach ($nameParts as $part) {
        $initials .= substr($part, 0, 1); // Lấy ký tự đầu
    }

    // chuyển ngày sinh thành chuỗi
    $dobParts = date('dmY', strtotime($dob));
    
    // trả về mã nhân viên VD: nguyenvh20031990
    return strtolower($lastName . $initials .  $dobParts);
}

function now(){
    return Carbon\Carbon::now();
}

function formattedDate($date, $format = 'd/m/Y H:i:s')
{
    return date($format, strtotime($date));
}

function get($key, $default = null)
{
    return $_GET[$key] ?? $default;
}
