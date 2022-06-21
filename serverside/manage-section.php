<?php
require("Database.php");
require("header.php");

if(isset($_POST['actionString']) && $_POST['actionString']=="addSection")
{
    $sectionName=$_POST['sectionName'];
    $departmentid= $_POST['departmentId'];

    $query = "insert into section (sectionname,departmentid)
 values ('".$sectionName."','".$departmentid."')";
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
} else if(isset($_POST['actionString']) && $_POST['actionString']=='deleteSection'){
    $sectionId=$_POST['sectionId'];
    $query = "delete from section where sectionid='".$sectionId."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;

} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateSection')
{
    $sectionId=$_POST['sectionId'];
    $query ="select department.departmentname,section.* from section inner join department on department.departmentid = section.departmentid where sectionid='".$sectionId."'";
    if(mysqli_query($connection,$query)) {
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $sectionId = $row['sectionid'];
        $sectionName = $row['sectionname'];
        $departmentId = $row['departmentid'];
        $return_array[] = array("departmentId" => $departmentId, "sectionName" => $sectionName, "sectionId" => $sectionId);
        echo json_encode($return_array);
        exit();
    }
    else
        echo false;
} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateSectionInfo')
{
    $sectionId = $_POST['sectionId'];
    $sectionName = $_POST['sectionName'];
    $departmentId = $_POST['departmentId'];
    $query=" update section set sectionname='$sectionName', departmentid='$departmentId' where sectionid='$sectionId'";
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
}
else {
    $query ="select department.departmentname,section.* from section inner join department on department.departmentid = section.departmentid where section.departmentid=".$_SESSION['departmentid'];
    $result = mysqli_query($connection,$query);
    $print="";
    while($row=mysqli_fetch_assoc($result))
    {
        $print.="<tr>
        <td>".$row['sectionid']."</td>
        <td>".$row['sectionname']."</td>
        <td>".$row['departmentname']."</td>
        <td><button class='btn btn-danger deleteSection' value='".$row['sectionid']."'>
        Delete Section</button> 
        <button class='btn btn-info editSection' value='".$row['sectionid']."'>Edit Section</button>
        <a href='employee.php?sectionId=".$row['sectionid']."&sectionName=".$row['sectionname']."'>
        <button class='btn btn-primary'>Manage Employee</button></a>
        <a href='calender.php?sectionId=".$row['sectionid']."&sectionName=".$row['sectionname']."'>
        <button class='btn btn-success' value='".$row['sectionid']."'>Manage Duty</button> 
        </a>    
         </td>
         </tr>";
    }
    echo $print;

}
?>
