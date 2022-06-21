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
            <form id="userForm">
                <div class="form-row">
                    <div class="col">
                        <input type="text" id="username"  class="form-control" placeholder="Username">
                    </div>
                    <div class="col">
                        <input type="password" id="password"  class="form-control" placeholder="Password">
                    </div>
                    <div class="col">
                        <input type="text" id="user-description"  class="form-control" placeholder="User description">
                    </div>
                    <div class="col">
                        <select id="privilage" class="custom-select">
                            <option selected value="normal">Normal</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col">
                        <input type="button" class="btn btn-primary" id="addUser" value="save">
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
                <th>Username</th>
                <th>Password</th>
                <th>Privilage</th>
                <th>Description</th>
                <th colspan="2">Action</th>
                </thead>
                <tbody id="userResult">

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
<div class="modal fade" id="userUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="text-align:center;" class="modal-title" id="exampleModalLabel">Update User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="close-button">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userUpdateModalBody">
                <form class="form-row" id="userUpdateForm">
                    <div class="col-2">
                        <input type="text" disabled name="username"  class="form-control username">
                    </div>
                    <div class="col-2">
                        <input type="password" placeholder="password" name="password"  class="form-control password">
                    </div>
                    <div class="col-2">
                        <select class="custom-select privilage" name="privilage">
                            <option value="normal">Normal</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-3">
                        <input type="text"  class="form-control description" name="description" placeholder="Description">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-primary" id="updateUser" >Update</button>
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
<script src="js/users.js">



</script>
</body>

</html>
