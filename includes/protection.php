<?php
//session_start();
//echo 'test';var_dump($_SESSION['user_is_admin']);
if (!($_SESSION['user_is_admin'] == true))
{
    //echo 'go';
    header ('location: http://'.$_SERVER['HTTP_HOST'].'/gx_2/content/login.php');
}
