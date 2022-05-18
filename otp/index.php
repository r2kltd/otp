<?php
/*
ONE TIME SHARE PASSWORD AND SECRET
Version: 1.0
Author: Khalil jarban
*/
session_start();
 



//define paths
define('DOMAIN_URL','https://otp.r2k.co.il/');//root path
define('ABSPATH', dirname(__FILE__).'/');//root path
define('HIDDENPATH',dirname(dirname(__FILE__)).'/hiddentunnel/');//path of folder to save the secrets
define('NONCELIFETIME',3600); //for security reasons keep it as lower you can
define('SESKEY','ugdhfudfhu'); //for security reasons change it to random string
define('TIMEZONE','Asia/Jerusalem'); //https://www.php.net/manual/en/timezones.php

 
 

//init the session
if(!isset($_SESSION[SESKEY])){
    $_SESSION[SESKEY]=[];
}


 
//include general functions file
include_once(ABSPATH.'functions.php');

//get user ip to hash a nonce later for security
$user_ip = getUserIP();
$server_ip = $_SERVER['SERVER_ADDR'];

//generate a new nonce if not available,  otherwise take it from session
if(empty($_SESSION[SESKEY]['nonce']) || $_SESSION[SESKEY]['nonce_expire']<time()){
    $nonce = md5(time().$user_ip);
    $_SESSION[SESKEY]['nonce'] =$nonce;
    $_SESSION[SESKEY]['usr_ip'] = md5($user_ip);
    $_SESSION[SESKEY]['srv_ip'] = md5($server_ip);
    $_SESSION[SESKEY]['nonce_expire'] = time()+NONCELIFETIME;
}else{
    $nonce = $_SESSION[SESKEY]['nonce'] ;
}


 
$isTherePostedFormMessage=false;
if(!empty($_POST)){

    if(verifyNonce($_POST,$nonce)){


        $data=[];
        $data['cnt'] = strip_tags($_POST['cnt']);
        $data['expire'] = intval($_POST['expire']);
        if(intval($data['expire'])>604800 || intval($data['expire'])<300){
            $isTherePostedFormMessage='Please, verify your life time setting' ;
        }else{
            $data['expire']=$data['expire']+time();

            $fileKey = md5(rand(0,10000).time().$user_ip);



            $path = HIDDENPATH.$fileKey.'.json';
            file_put_contents($path,json_encode($data));


            $isTherePostedFormMessage='<label for="otp_url">Success, your secret link is:</label>';
            $isTherePostedFormMessage.='<input id="otp_url" type="text" readonly value="'.DOMAIN_URL.'?tkn='.$fileKey.'" />';
            $isTherePostedFormMessage.='<span class="expire_note">Will expired at: '.date('m/d/Y H:i',$data['expire']).'</span>';


            //clear posted data
            $_POST=[];

            //clear session
            $_SESSION=[];
        }



    }else{
        $isTherePostedFormMessage='Your session has been ended, please try again';
    }


}


$title='Put your secret content';
if(!empty($_GET['tkn'])){
    $title='Click to continue';
}else if(!empty($_GET['tkn']) && !empty($_GET['do'])){
    $title='Here your secret';
}
?>

<!DOCTYPE html>
<html>
    <head>
          <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>One time password share</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="all" href="assets/style.css?v=2"/> 
        
        
    </head>
    <body>
        <div class="container">
            <h1><?php echo $title; ?></h1>
            <div class="cols">
            <div class="col-1-1">
                <?php
                if($isTherePostedFormMessage){
                    echo '<p class="otp_message">'.$isTherePostedFormMessage.'</p>';
                }
                
                
                if(!empty($_GET['tkn'])){
                    include(ABSPATH.'views/content.php');
                }else{
                    include(ABSPATH.'views/form.php');
                    
                }

                ?>
                 
                </div>
            <div class="col-1-1">
                
                </div>
        </div>
        </div>
    </body>
</html>
