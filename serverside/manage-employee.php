<?php
require("Database.php");
require("header.php");

if(isset($_POST['actionString']) && $_POST['actionString']=="addEmployee")
{
    $employeeName=$_POST['employeeName'];
    $employeeId = $_POST['employeeId'];
    $employeeDesignation = $_POST['employeeDesignation'];
    $sectionId = $_POST['sectionId'];
    $query = "insert into employee (employeeid,employeename,employeedesignation,sectionid)
 values ('".$employeeId."','".$employeeName."','".$employeeDesignation."','".$sectionId."')";
   //echo $query;
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
} else if(isset($_POST['actionString']) && $_POST['actionString']=='deleteEmployee'){
    $employeeId=$_POST['employeeId'];
    $query = "delete from employee where employeeid='".$employeeId."'";
    if(mysqli_query($connection,$query))
        echo true;
    else
        echo false;

} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateEmployee')
{
    $employeeId=$_POST['employeeId'];
    $query ="select section.sectionname,employee.* from section inner join employee on employee.sectionid = section.sectionid where employeeid='".$employeeId."'";
    if(mysqli_query($connection,$query)) {
        $result = mysqli_query($connection, $query);
        $row = mysqli_fetch_assoc($result);
        $sectionId = $row['sectionid'];
        $employeeName = $row['employeename'];
        $employeeId = $row['employeeid'];
        $employeeDesignation=$row['employeedesignation'];
        $return_array[] = array("sectionId" => $sectionId, "employeeName" => $employeeName, "employeeId" => $employeeId, "employeeDesignation" => $employeeDesignation);
        echo json_encode($return_array);
        exit();
    }
    else
        echo false;
} else if(isset($_POST['actionString']) && $_POST['actionString']=='updateEmployeeInfo')
{
    $employeeName=$_POST['employeeName'];
    $employeeId = $_POST['employeeId'];
    $employeeDesignation = $_POST['employeeDesignation'];
    $sectionId = $_POST['sectionId'];
    $query=" update employee set employeename='$employeeName', employeedesignation='$employeeDesignation' where employeeid='$employeeId'";
    if(mysqli_query($connection,$query))
        echo "true";
    else
        echo "false";
}
else if(isset($_GET['sectionId']))
{
    $sectionId=$_GET['sectionId'];
    $query ="select employee.*,section.sectionname from employee inner join section on employee.sectionid=section.sectionid where section.sectionid=".$sectionId;
    echo $query;
    $result = mysqli_query($connection,$query);
    $print="";
    while($row=mysqli_fetch_assoc($result))
    {
        $print.="<tr>
        <td>".$row['employeeid']."</td>
        <td>".$row['employeename']."</td>
        <td>".$row['employeedesignation']."</td>
        <td>".$row['sectionname']."</td>
        <td><button class='btn btn-danger deleteEmployee' value='".$row['employeeid']."'>
        Delete </button> 
        <button class='btn btn-info editEmployee' value='".$row['employeeid']."'>Edit </button>
         </td>
         </tr>";
    }
    echo $print;

}
?>
