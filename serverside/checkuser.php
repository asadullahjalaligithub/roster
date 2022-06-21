<?php require("database.php");
session_start();
if(isset($_POST['actionString']) && $_POST['actionString']=='login')
{
    $username=$_POST['username'];
    $password=$_POST['password'];
    $action = $_POST['actionString'];
    $query = "select * from users where username='$username' and password='$password'";
    $result = mysqli_query($connection,$query);
$message="true";
    if(mysqli_num_rows($result)!=0)
    {


        $row =mysqli_fetch_assoc($result);
        $_SESSION['userid']=$row['userid'];
        $_SESSION['username']=$row['username'];
        $_SESSION['password']=$row['password'];
        $_SESSION['privilage']=$row['privilage'];
        $_SESSION['loginstatus']=true;
       $message="true";
        if($row['privilage']=='normal')
        {
            $query="select * from department where userid=".$row['userid'];
            $result=mysqli_query($connection,$query);
            $record=mysqli_fetch_assoc($result);
            $_SESSION['departmentid']=$record['departmentid'];
            $_SESSION['departmentname']=$record['departmentname'];
        }
    }
    else {
        $message="false";
    }
    echo $message;
}

?>
