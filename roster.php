<?php
require('serverside/header.php');
require('serverside/database.php');
if($_SESSION['privilage']=='admin' || !isset($_GET['yearmonthid']) || !isset($_GET['sectionid']) || !isset($_GET['yearname']) || !isset($_GET['monthnumber']))
{
    header('location:dashboard.php');
    exit();
}
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
<?php require('serverside/top-link.php');
                        $sql="select * from monthtable where monthnumber=".$_GET['monthnumber'];
                        $table=mysqli_query($connection,$sql);
                        $record=mysqli_fetch_assoc($table);
                        echo "<h5 align='center' class='text-white bg-dark p-1'>".$_GET['yearname']." ".$record['monthname']."</h5>";

$query0="select * from employee where sectionid=".$_GET['sectionid'];
$result0=mysqli_query($connection,$query0);
while($row0=mysqli_fetch_assoc($result0))
{
    $query = "select * from estimation inner join employee on employee.employeeid=estimation.employeeid where estimation.monthid=".$_GET['yearmonthid']." and estimation.employeeid=" . $row0['employeeid'];
//echo $query;
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result)==0)
    {
        $query = "insert into estimation (employeeid,monthid,hours) values (" . $row0['employeeid'] . ", " . $_GET['yearmonthid'] . ",0)";
        mysqli_query($connection, $query);

    }
}

// inserting the data if doens't exist
$month=$_GET['monthnumber'];
$year=$_GET['yearname'];
$weekdays=array();
$days=cal_days_in_month(CAL_GREGORIAN,$month,$year);



$query0="select * from employee where sectionid=".$_GET['sectionid'];
$result0=mysqli_query($connection,$query0);
while($row0=mysqli_fetch_assoc($result0)) {
    $query = "select * from employeeduty inner join employee on employeeduty.employeeid=employee.employeeid where employeeduty.monthid=" . $_GET['yearmonthid'] . " and employee.employeeid=" . $row0['employeeid'];
    $result = mysqli_query($connection, $query);
    if (mysqli_num_rows($result) == 0) {
       // $query = "select * from employee where sectionid='" . $_GET['sectionid'] . "'";
        //$result = mysqli_query($connection, $query);
        //while ($row = mysqli_fetch_assoc($result)) {
            for ($i = 1; $i <= $days; $i++)
                {
                    $query = "insert into employeeduty (employeeid,monthid,monthday,keywordsid) values 
       (" . $row0['employeeid'] . "," . $_GET['yearmonthid'] . "," . $i . ",'906')";
                    mysqli_query($connection, $query);
                }

        }
    //}
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-3 left-roster">
            <table class="table table-bordered">
                <thead class="table-dark">

                <tr>
                    <th style="width:50px">ID</th>
                    <th>Name</th>
                    <th style="width:20px">Estimation</th>
                </tr>
                </thead>
                <tbody>

                <?php

                // values of duties
                $query="select * from keywords";
                $result=mysqli_query($connection,$query);
                $list_values =array();
                while($row=mysqli_fetch_array($result))
                {
                    $array=array("$row[0]"=>"$row[1]");
                    array_push($list_values,$array);
                }
                $query="select employee.employeeid as employeeid, employee.employeename as employeename,estimation.* from employee inner join estimation on employee.employeeid = estimation.employeeid where employee.sectionid='".$_GET['sectionid']."' and estimation.monthid=".$_GET['yearmonthid']." order by employee.employeeid asc";
              //  echo $query;
                $result=mysqli_query($connection,$query);

                while($row=mysqli_fetch_assoc($result))
                {
                    ?>
                    <tr>
                        <td><?php echo $row['employeeid']; ?></td>
                        <td><?php echo $row['employeename']; ?></td>
                        <td>
                            <form>
                                <input type="hidden" name="estimationid" value="<?php echo $row['estimationid'];?>">

                                <input type="text" class="form-control form-control-sm" style="text-align:center;" size="3" name="estimation" onkeypress="updateEstimationHour(this.form,event);" value="<?php echo $row['hours']; ?>">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>
        <div class="roster-main col-9">
            <?php
            for($day=1;$day<=$days;$day++)
            {
                $weekday=date("l", mktime(0, 0, 0, $month, $day, $year));
                array_push($weekdays,$weekday);
            }

            ?>
            <table id="main-table" class="table table-bordered">
                <thead class="thead-dark">
                <tr>
                    <?php
                    $print="";
                    foreach ($weekdays as $value)
                    {
                        $print.="
                <th>$value</th>
                ";
                    }
                    echo $print;
                    ?>
                </tr>
                <tr>
                    <?php
                    $print="";
                    for($i=1;$i<=$days;$i++)
                        $print.="<th>$i</th>";;
                    echo $print;
                    ?>
                </tr>
                </thead>
                <tbody id="main-table-body">
                <?php
                $q = "select * from employee where sectionid='".$_GET['sectionid']."' order by employee.employeeid asc";
                $res=mysqli_query($connection,$q);
                while($rw=mysqli_fetch_assoc($res))
                {
                    $query = "select employeeduty.* from employeeduty 
      inner join employee ON  employeeduty.employeeid = employee.employeeid 
inner join yearmonth on yearmonth.yearmonthid = employeeduty.monthid
where employeeduty.monthid='".$_GET['yearmonthid']."' and employeeduty.employeeid='".$rw['employeeid']."' order by employeeduty.monthday asc";
                    $result = mysqli_query($connection, $query);
                    $print = "<tr>";
                    while ($row = mysqli_fetch_assoc($result))
                    {
                        $print .= "<td>
                        <form>
                        <input type='hidden' name='employeedutyid' value='" . $row['employeedutyid'] . "'>
                        <select class='custom-select-sm' name='dutyvalue' onchange='update(this.form)'>";
                        foreach ($list_values as $values) {
                            foreach ($values as $key => $value) {
                                if ($row['keywordsid'] == $key)
                                    $print .= "<option selected value='" . $key . "'>$value</option>";
                                else
                                    $print .= "<option  value='" . $key . "'>$value</option>";
                            }
                        }
                        $print .= "</select></form></td>";
                        echo $print;
                        $print="";
                    }
                    echo "</tr>";
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel" id="modal-title">Message</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="btn btn-primary" id="close-button">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<?php require('serverside/footer.php');
?>
<script>

    function updateEstimationHour(formid,event)
    {
    if(event.keyCode==13)
    {
        event.preventDefault();

        var estimationid=formid.estimationid.value;
        var estimation=formid.estimation;
        if (estimation.value == "" || isNaN(estimation.value)==true) {
            $('#myModal').modal('show');
            $('#modal-body').text("The Box is Empty or you have entered an invalid number");
        } else $.ajax({
            url: 'serverside/dashboard-php.php',
            type: 'POST',
            data: {
                estimationid:estimationid,
                estimation: estimation.value,
                actionString: "updateEstimationValue"
            },
            success: function (response) {
                if (response.trim()==false) {
                    $('#myModal').modal('show');
                    $('#modal-body').text("Couldn't Update the Estimation Value");
                } else {
                    $('#myModal').modal('show');
                    $('#modal-body').text("Estimation Hour updated Successfully");
                }
            }
        });
    }
    }

    function update(formid){
        var employeedutyid = formid.employeedutyid.value;
        var dutyvalue = formid.dutyvalue.value;
        $.ajax({
            url: 'serverside/dashboard-php.php',
            type: 'POST',
            data: {
                employeedutyid:employeedutyid,
                dutyvalue:dutyvalue,
                actionString:'update'
            },
            success: function (response) {
                if(response.trim()==false)
                   // alert("record updated successfully");
                //else
                {
                    $('#myModal').modal('show');
                    $('#modal-body').text("Couldn't Update the duty hour Value");
                }
            }
        });

    }


    $(document).ready(function() {
        $('#main-table').tableHover({
            rowClass: 'hoverrow',
            colClass: 'hover',
            clickClass: 'click',
            headRows: true,
            footRows: true,
            headCols: true,
            footCols: true
        });
    });

</script>
</body>

</html>