<!doctype html>
<html class="no-js" lang="">
    <?php
    include_once '../includes/config.php';
    //include_once INC . 'protection.php';
    //include_once INC . 'header.php';
      
    //var_dump($_POST);
    // test d'un envoi post
    if(isset($_POST['submit']) && $_POST['submit'] == '1')
    {
        
        //die();
        //test validité cx
        $cx = logAdmin($_POST['login'], $_POST['password']);  
        //var_dump($cx);
        header ('location: http://'.$_SERVER['HTTP_HOST'].'/gx_2/');
        
    }
    // formulaire de connexion
    ?>
    <form action="<?php echo LINK_BASE_URL; ?>content/login.php" method="post">
        <fieldset>
            <legend>STC/44.9</legend>
            <br />
            
            <label for="login"><b>num. de coupon</b></label>
            <br />
            <input type="text" name="login" id="login" value="" size="3"/>
            <br/>

            <label for="password">num. de bureau</label> 
            <br />
            <input type="password" name="password" id="password" value="" size="3"/> 
            <br />
            <br />
            <div>  
                <button class="buttoon" type="submit" name="submit" value="1" />Go</button>
            </div> 
            <br />			  
        </fieldset>
        </form>  
        
    <?php
    die();