<?php
require("Database.php");

if(isset($_POST['actionString']) && $_POST['actionString']=="addDepartment")
{
    $departmentName=$_POST['departmentName'];
    $userid= $_POST['userId'];

    $query = "insert into department (departmentname,userid)
 values ('".$departmentName."','".$userid."')";
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
} else if(isset($_POST['actionString']) && $_POST['actionString']=='deleteDepartment'){
    $departmentId=$_POST['departmentId'];
    $query = "delete from department where departmentid='".$departmentId."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;

} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateDepartment')
{
    $departmentId=$_POST['departmentId'];
    $query ="select department.*,users.username from department inner join users on users.userid = department.userid where departmentid='".$departmentId."'";
    if(mysqli_query($connection,$query)) {
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $departmentId = $row['departmentid'];
        $departmentName = $row['departmentname'];
        $userId = $row['userid'];
        $return_array[] = array("departmentId" => $departmentId, "departmentName" => $departmentName, "userId" => $userId);
        echo json_encode($return_array);
        exit();
    }
    else
        echo false;
} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateDepartmentInfo')
{
    $departmentId = $_POST['departmentId'];
    $departmentName = $_POST['departmentName'];
    $userId = $_POST['userId'];
    $query=" update department set departmentname='$departmentName', userid='$userId' where departmentid='$departmentId'";
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
}
else {
    $query ="select department.*,users.username from department inner join users on users.userid = department.userid";
    $result = mysqli_query($connection,$query);
    $print="";
    while($row=mysqli_fetch_assoc($result))
    {
        $print.="<tr>
        <td>".$row['departmentid']."</td>
        <td>".$row['departmentname']."</td>
        <td>".$row['username']."</td>
        <td><button class='btn btn-danger deleteDepartment' value='".$row['departmentid']."'>
        Delete</button> 
        <button class='btn btn-info editDepartment' value='".$row['departmentid']."'>Edit</button>
         </td>
         </tr>";
    }
    echo $print;

}
?>
