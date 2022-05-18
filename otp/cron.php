<?php

include_once(dirname(__FILE__).'/conf.php');



$rootPath =HIDDENPATH;
    

$fileList = glob($rootPath.'*.json');
if(!empty($fileList2)){
    foreach ($fileList2 as $f){
        $fileList[]=$f;
    }
}
if(!empty($fileList)){
        foreach ($fileList as $f){
            $c=filemtime($f);
            if($c< strtotime('-2 days')){
                unlink($f);
            }
        }
}