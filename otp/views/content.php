<?php

if(!defined('ABSPATH')){
    die();
}


$do=!empty($_GET['do']) ? $_GET['do'] : false;
$tkn=!empty($_GET['tkn']) ? $_GET['tkn'] : false;
$tkn = strip_tags($tkn);

$isValid= false;
$path = HIDDENPATH.$tkn.'.json';
if(file_exists($path)){
    $content = file_get_contents($path);
    if(!empty($content)){
            $isValid = json_decode($content,true);
    }
}

 
if(!$isValid){
    echo '<p class="otp_message">Content no more available!</p>';
    
    echo '<a href="index.php" class="btn">Generate a new one</a>';
 
}elseif($do && $tkn ){
    
 
    
                ?>
                  <div class="group">
                    <label for="cnt">Hidden content</label>
                    <textarea readonly="" id="cnt"  name="cnt" ><?php echo $isValid['cnt']; ?></textarea>
                </div>

            <?php
            
            
                            unlink($path);
                            
                            echo '<a href="index.php" class="btn">Generate a new one</a>';
 
}else{

    
      echo '<p class="otp_message">Note, content will shown only once!</p>';
?>
<form method="get" action="index.php">
    <input type="hidden" name="do" value="show" />
    <input type="hidden" name="tkn" value="<?php echo $tkn; ?>" />
   
    <button>Show secret content </button>


</form>

<?php
}



     