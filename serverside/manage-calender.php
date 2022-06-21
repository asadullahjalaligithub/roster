<?php

require('checkuser.php');
require('database.php');

if(isset($_POST['actionString']) && $_POST['actionString']=='updateWorkingHours')
{
    $query = "update yearmonth set workinghours='".$_POST['workingHours']."' where yearmonthid='".$_POST['yearmonthid']."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;
}
?>