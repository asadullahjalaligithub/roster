<?php
require('serverside/header.php');
require('serverside/database.php');
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="font-awesome/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/dashboardstyle.css">
</head>

<body>
<?php
$q2 = "select * from monthtable where monthname='january'";
$r2 = mysqli_query($connection,$q2);
$row2=mysqli_fetch_assoc($r2);
$q3 = "select * from yeartable where yearname='2020'";
$r3 = mysqli_query($connection,$q3);
$row3=mysqli_fetch_assoc($r3);
$yearname=$row3['yearname'];
$monthname=$row2['monthname'];
$q4="select yearmonth.yearmonthid,yearmonth.yearid,yearmonth.monthid from yearmonth
    inner join yeartable on yearmonth.yearid=yeartable.yearid
    inner join monthtable on yearmonth.monthid=monthtable.monthid
    where yeartable.yearname='".$yearname."' 
    and monthtable.monthname='".$monthname."'";
$r4=mysqli_query($connection,$q4);
$row4=mysqli_fetch_assoc($r4);
$monthyearid=$row4['yearmonthid'];

// days of the month
$month=7;
$year=2020;
$weekdays=array();
$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);

$q1 = "select * from employee where sectionid='201'";
$r1=mysqli_query($connection,$q1);
while($emp=mysqli_fetch_assoc($r1))
{
    for($day=1;$day<=$days;$day++)
    {
        $emplyeeid=$emp['employeeid'];
        $insertquery="insert into employeeduty (employeeid,monthid,monthday,keywordsid)
  values($emplyeeid,$monthyearid,$day,'906')";
        mysqli_query($connection,$insertquery);
    }
}

?>
<script src="js/jquery.js"></script>
<script src="js/popper.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script>

</script>
</body>

</html>
