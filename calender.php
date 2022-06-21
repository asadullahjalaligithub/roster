<?php
require('serverside/header.php');
require('serverside/database.php');
if($_SESSION['privilage']=='admin' || !isset($_GET['sectionId']) || !isset($_GET['sectionName']))
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
    <style>
        .container-fluid a {
            color:black !important;
            display:block !important;
        }
        .container-fluid a:hover{
            color:white !important;
            font-weight:bold !important;
            text-decoration:none;
        }
    </style>
</head>

<body>
<?php require('serverside/top-link.php'); ?>
<div class="container-fluid">
    <div class="row">
        <?php
        $query="select distinct yearmonth.yearid,yeartable.yearname from yearmonth inner join yeartable on yearmonth.yearid=yeartable.yearid";
        $result=mysqli_query($connection,$query);
        while($row=mysqli_fetch_assoc($result))
        {
            ?>
        <div class="jumbotron col-4  bg-white ">
            <h4 class="btn btn-info d-block"><?php echo $row['yearname'] ?></h4>
        <table class="table table-striped">
            <thead>
            <th>Month</th>
            <th>Report</th>
            <th>Normal Duty Hours</th>
            <th>Status</th>
            </thead>
            <tbody>
            <?php
        $query = "select monthtable.monthname,monthtable.monthnumber,yearmonth.* from yearmonth inner join monthtable on monthtable.monthid=yearmonth.monthid where yearid=" . $row['yearid'];
        $result2=mysqli_query($connection,$query);
        while($row2=mysqli_fetch_assoc($result2))
        {
        ?><tr>
                <td>
            <button class="btn btn-outline-danger w-100 ">
                <a  href="roster.php?yearmonthid=<?php echo $row2['yearmonthid'].'&sectionid='.$_GET['sectionId'].'&yearname='.$row['yearname'].'&monthnumber='.$row2['monthnumber'];?>">
                    <?php echo $row2['monthname']; ?>
                </a>
            </button>
                </td>
                <td>
                    <button class="btn btn-outline-success w-100">
                    <a href="report.php?yearmonthid=<?php echo $row2['yearmonthid'].'&sectionid='.$_GET['sectionId'].'&yearname='.$row['yearname'].'&monthnumber='.$row2['monthnumber'];?>">
                            Print
                        </a>
                    </button>
                </td>
                <td>
                    <form class="workingHoursForm">
                        <input type="hidden" name="yearmonthid" class="yearmonthid" value="<?php echo $row2['yearmonthid'];?>">
                        <input type="text" class="form-control workingHours" style="text-align:center;" size="3"   name="workinghours" value="<?php echo $row2['workinghours']; ?>">
                    </form>
                </td>
                <td class="status">
                  <?php echo $row2['status']; ?>
                </td>
            </tr>
        <?php
        }?>
            </tbody>
        </table>

        </div>

        <?php } ?>
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
?><script>
    $(document).ready(function() {
        $('.status').text(function(){
           if($(this).text().trim()=='locked')
           {
               $(this).parents('tr:first').find('.btn-outline-danger a').removeAttr('href');
               $(this).parents('tr:first').find('.btn-outline-danger').addClass('btn-warning');
               $(this).parents('tr:first').find('.btn-warning').removeClass('btn-outline-danger');
               $(this).parents('tr:first').find('.workingHoursForm input').attr('disabled','disabled');
           }
        });

      /* $('.status').(function(){
           if($(this).text().trim()==='locked')
           {
               $(this).parents('tbody:first').find('.btn-outline-danger a').text('hello');
               $(this).parents('tbody:first').find('.btn-outline-danger a').removeAttr('href');
               $(this).parents('tbody:first').find('.btn-outline-danger').addClass('btn-outline-warning');
               $(this).parents('tbody:first').find('.btn-outline-danger').removeClass('btn-outline-danger');
                $(this).parents('tbody:first').find('input').addClass('disabled');
           }
       });*/
        $('.workingHoursForm').on('keydown','.workingHours',function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
           //console.log($(this).val());
                     var workinghours=$(this).val();
                var yearmonthid = $(this).parents('form:first').find('.yearmonthid').val();
                if (workinghours == "" || isNaN(workinghours) == true) {
                    $('#myModal').modal('show');
                    $('#modal-body').text("The Box is Empty or you have entered an invalid number");
                } else $.ajax({
                    url: 'serverside/manage-calender.php',
                    type: 'POST',
                    data: {
                        yearmonthid: yearmonthid,
                        workingHours: workinghours,
                        actionString: "updateWorkingHours"
                    },
                    success: function (response) {
                        if (response.trim() == false) {
                            $('#myModal').modal('show');
                            $('#modal-body').text("Couldn't Update the Normal Working Hours Value");
                        } else {
                            $('#myModal').modal('show');
                            $('#modal-body').text("Normal Working Hour updated Successfully");
                        }
                    }
                });
            }
        });

    });
</script>
</body>


</html>
