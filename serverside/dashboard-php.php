<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 8/25/2020
 * Time: 1:42 PM
 */
require('checkuser.php');
require('database.php');

if(isset($_POST['actionString']) && $_POST['actionString']=='update')
{
    $query = "update employeeduty set keywordsid='".$_POST['dutyvalue']."' where employeedutyid='".$_POST['employeedutyid']."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;
}
if(isset($_POST['actionString']) && $_POST['actionString']=='updateEstimationValue')
{
    $query = "update estimation set hours='".$_POST['estimation']."' where estimationid='".$_POST['estimationid']."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;
}
?>