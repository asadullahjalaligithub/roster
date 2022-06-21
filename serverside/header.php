<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/7/2020
 * Time: 8:40 PM
 */

session_start();
if(!isset($_SESSION['loginstatus']))
{
    header("location:index.php");
}


?>