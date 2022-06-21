<?php
require('serverside/header.php');
require('serverside/database.php');
if($_SESSION['privilage']=='normal')
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
        .error {
            border:solid 0.5px red;
        }
    </style>
</head>

<body>
<?php require('serverside/top-link.php'); ?>
<div class="container-fluid">
    <div class="row text-center p-4">
        <div class="col-9">
            <form id="departmentForm">
                <div class="form-row">
                    <div class="col">
                        <input type="text" id="department-name"  class="form-control" placeholder="Department Name">
                    </div>
                    <div class="col">
                        <select id="userid" class="custom-select">
                            <?php
                            $query="select * from users";
                            $table=mysqli_query($connection,$query);
                            while($row=mysqli_fetch_assoc($table))
                            {
                            ?>
                            <option selected value="<?php echo $row['userid'] ?>"><?php echo $row['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <input type="button" class="btn btn-primary" id="addDepartment" value="save">
                        <input type="reset" value="clear" class="btn btn-warning">
                    </div>

                </div>
            </form>
        </div>

    </div>
    <div class="row">
        <div class="col">


            <table class="table table-striped mt-5 p-4">
                <thead>
                <th>ID</th>
                <th>Department Name</th>
                <th>Users</th>
                <th colspan="2">Action</th>
                </thead>
                <tbody id="departmentResult">

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
<div class="modal fade" id="departmentUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="text-align:center;" class="modal-title" id="exampleModalLabel">Update Department</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="close-button">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="departmentUpdateModalBody">
                <form class="form-row" id="departmentUpdateForm">
                    <div class="col-5">
                        <input type="text"  name="department-name"  class="form-control departmentName">
                        <input type="hidden"  name="department-id"  class="form-control departmentId">
                    </div>
                    <div class="col-4">
                        <select id="userId" class="custom-select">
                            <?php
                            $query="select * from users";
                            $table=mysqli_query($connection,$query);
                            while($row=mysqli_fetch_assoc($table))
                            {
                                ?>
                                <option  value="<?php echo $row['userid'] ?>"><?php echo $row['username']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-3">
                        <button type="button" class="btn btn-primary" id="updateDepartment" >Update</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php require('serverside/footer.php'); ?>
<script src="js/department.js">



</script>
</body>

</html>
