<?php
require('serverside/database.php');

if(isset($_GET['yearmonthid']) && isset($_GET['sectionid']) && isset($_GET['yearname']) && isset($_GET['monthnumber'])) {

    $yearmonthid=$_GET['yearmonthid'];
    $sectionid=$_GET['sectionid'];
    $yearname=$_GET['yearname'];
    $monthnumber=$_GET['monthnumber'];
$query1="select * from employee inner join section on employee.sectionid = section.sectionid 
 inner join department on department.departmentid=section.departmentid 
 where section.sectionid=$sectionid";
$result1=mysqli_query($connection,$query1);
    $row1=mysqli_fetch_assoc($result1);
$table="
<table border='1px'>
<thead>
<tr>
<th colspan='2'>Department Name</th>
<th colspan='3'>".$row1['departmentname']."</th>
</tr>
<tr>
<th colspan='2'>Section Name</th>
<th colspan='3'>".$row1['sectionname']."</th>
</tr>
<tr>
<th>ID</th>
<th>Name</th>
<th>Designation</th>
<th>Working Hours</th>
<th>OverTime</th>
</tr>
</thead>
<tbody>";
// retrieving from beginning
    $result1=mysqli_query($connection,$query1);
while($row1=mysqli_fetch_assoc($result1)) {
    $query2="
create or replace view
monthlyreport as
select
section.sectionid AS sectionid,
section.sectionname AS sectionname,
section.departmentid AS departmentid,
yearmonth.yearmonthid AS yearmonthid,
yearmonth.yearid AS yearid,
yearmonth.monthid AS monthid,
yearmonth.workinghours AS workinghours,
yearmonth.status AS status,
employee.employeeid AS id,
employee.employeename AS employeename,
employee.employeedesignation AS employeedesignation,
employeeduty.monthid AS month,
keywords.keywordsvalue AS keywordsvalue,
yeartable.yearname as yearname,
monthtable.monthname as monthname
from employeeduty inner join employee on employee.employeeid = employeeduty.employeeid
 inner join section on section.sectionid = employee.sectionid 
 inner join keywords on employeeduty.keywordsid = keywords.keywordsid 
  inner join yearmonth on yearmonth.yearmonthid = employeeduty.monthid
  inner join yeartable on yeartable.yearid=yearmonth.yearid
  inner join monthtable on monthtable.monthid=yearmonth.monthid
where employee.employeeid=".$row1['employeeid']." and yearmonth.yearmonthid=$yearmonthid";

    //echo $query2."<br>";
    mysqli_query($connection,$query2);
    $query2="select * from monthlyreport";
        // obtaining the normal working hours
    $result2=mysqli_query($connection,$query2);

    $row2=mysqli_fetch_assoc($result2);
    // creating total hours view
    $query3="create or replace view totalhours as 
    select sum(monthlyreport.keywordsvalue) as hours from monthlyreport";
    mysqli_query($connection,$query3);
    // selecting total hours view
    $query3="select * from totalhours";
    $result3=mysqli_query($connection,$query3);
    $row3=mysqli_fetch_assoc($result3);
    // obtaining the estimation value
    $query4="select * from estimation where monthid=$yearmonthid and employeeid=".$row1['employeeid'];
    $result4=mysqli_query($connection,$query4);
    $row4=mysqli_fetch_assoc($result4);
    $hours=$row3['hours']+$row4['hours'];
    $overtime=$hours-$row2['workinghours'];
    $table.="
    <tr>
    <td>".$row1['employeeid']."</td>
    <td>".$row1['employeename']."</td>
    <td>".$row1['employeedesignation']."</td>
    <td>".$hours."</td>
    <td>".$overtime."</td>
    </tr>
    ";
}
$table.="
<tr>
<td colspan='2'>Normal Working Hours </td>
<td colspan='3'>".$row2['workinghours']."</td>
</tr>
<tr>
<td colspan='2'>Month Report </td>
<td colspan='3'>".$row2['monthname']."</td>
</tr>
<tr>
<td colspan='2'>Year Report </td>
<td colspan='3'>".$row2['yearname']."</td>
</tr>

<tr>
<td colspan='2' >Prepared By :  </td>
<td colspan='3' > </td>
</tr>
<tr>
<td colspan='5'></td>
</td>
</tr>
<tr>
<td colspan='2' >Approved By :  </td>
<td colspan='3' > </td>
</tr>

<tr>
<td colspan='5'></td>
</td>
</tr>
</tbody>
        </table>";
    header('Content-Type: application/xls');
    header('Content-Disposition: attachement; filename=download.xls');

    echo $table;
}
?>