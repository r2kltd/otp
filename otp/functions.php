<?php
if(!defined('ABSPATH')){
    die();
}

//set time zone 
date_default_timezone_set(TIMEZONE);

/*
 * get user IP
 */
function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

/*
 * verify nonce
 */
function verifyNonce($post,$nonce){
    
    if(empty($post)){
        return false;
    }
    if(empty($post['nonce'] )){
        return false;
    }
    if(empty($_SESSION[SESKEY]['nonce'])){
        return false;
    }

    
    // nonce expired 
    if($_SESSION[SESKEY]['nonce_expire']<time()){
        return false;
    }

    if($post['nonce'] != $nonce){
        return false;
    }

    
    $user_ip = getUserIP();
    $server_ip = $_SERVER['SERVER_ADDR'];

    if($_SESSION[SESKEY]['usr_ip']!= md5($user_ip)){
        return false;
    }

    if($_SESSION[SESKEY]['srv_ip']!=md5($server_ip)){
        return false;
    }

    return true;
}