<?php

if(!defined('ABSPATH')){
    die();
}


?>


<ul>
    <li>Link life time 48 hours</li>
    
</ul>
<form method="post" action="index.php">
                    <input type="hidden" name="nonce" value="<?php echo $nonce; ?>" />
                    <fieldset>
                        <legend>Content:</legend>
                        <div class="group">
                            <label for="cnt">Hidden content</label>
                            <textarea required="" id="cnt"  name="cnt" ></textarea>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Additional settings:</legend>
                        <div class="group">
                        <label for="expire">Life time</label>
                        <select id="expire"  name="expire" >
                        
                            <option value="172800">2 Days</option>
                        </select>
                        </div>
                    </fieldset>

                    <button>Generate a secure link</button>


                </form>

<?php