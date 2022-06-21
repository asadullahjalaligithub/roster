<?php
require("Database.php");

if(isset($_POST['actionString']) && $_POST['actionString']=="addUser")
{
    $username=$_POST['username'];
    $password= $_POST['password'];
    $description =$_POST['description'];
    $privilage = $_POST['privilage'];
    $query = "insert into users (username,password,description,privilage)
 values ('".$username."','".$password."','".$description."','".$privilage."')";
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
} else if(isset($_POST['actionString']) && $_POST['actionString']=='deleteUser'){
    $userid=$_POST['userid'];
    $query = "delete from users where userid='".$userid."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;

} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateUser')
{
    $userid=$_POST['userid'];
    $query ="select * from users where userid='".$userid."'";
   if(mysqli_query($connection,$query)) {
       $result = mysqli_query($connection, $query);
       $row = mysqli_fetch_assoc($result);
       $username = $row['username'];
       $password = $row['password'];
       $privilage = $row['privilage'];
       $description = $row['Description'];
       $return_array[] = array("username" => $username, "password" => $password, "privilage" => $privilage, "description" => $description);
       echo json_encode($return_array);
       exit();
   }
   else
       echo false;
} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateUserInfo')
{
            $username = $_POST['username'];
            $password= $_POST['password'];
            $description =$_POST['description'];
            $privilage = $_POST['privilage'];
            $query=" update users set password='$password', privilage='$privilage', Description='$description' where username='$username'";
            if(mysqli_query($connection,$query))
                echo "true";
            else
                echo "false";
}
else {
    $query ="select * from users";
    $result = mysqli_query($connection,$query);
    $print="";
    while($row=mysqli_fetch_assoc($result))
    {
        $print.="<tr>
        <td>".$row['userid']."</td>
        <td>".$row['username']."</td>
        <td>".$row['password']."</td>
        <td>".$row['privilage']."</td>
        <td>".$row['Description']."</td>
        <td><button class='btn btn-danger deleteUser' value='".$row['userid']."'>
        Delete</button> 
        <button class='btn btn-info editUser' value='".$row['userid']."'>Edit</button>
         </td>
         </tr>";
    }
    echo $print;

}
?>
