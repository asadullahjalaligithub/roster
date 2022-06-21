
$(document).ready(function() {
    // loading users
    $('#userResult').load('serverside/manage-users.php');

// deleting users
$('#userResult').on('click','.deleteUser',function(){
   var userid=$(this).attr('value');
   $.ajax({
       url:'serverside/manage-users.php',
       method:'post',
       data: {
           userid:userid,
            actionString:'deleteUser'
       },
       success: function(response) {
           if(response.trim()==true)
           {
               $('#modal-body').text('User deleted successfully');
               $('#myModal').modal('show');
                $('#userResult').load('serverside/manage-users.php');
           }
           else
           {
               $('#myModal').modal('show');
               $('#modal-body').html('Failed to delete the user.<br> It seems the user is associated to a particular department');
           }
       }
   })
    });

    // save button request of add new user modal
    $('#addUser').on('click', function() {
        var username = $('#username');
        var password = $('#password');
        var privilage = $('#privilage').find(":selected");
        var description = $('#user-description')


        $('#userForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (username.val().trim() == "")
            username.addClass('error');
        else if (password.val().trim() == "")
            password.addClass('error');
        else if (description.val().trim() == "")
            description.addClass("error");
        else
            $.ajax({
                url: "serverside/manage-users.php",
                type: 'post',
                data: {
                    username: username.val(),
                    password: password.val(),
                    description: description.val(),
                    privilage: privilage.val(),
                    actionString: 'addUser'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#myModal').modal('show');
                        $('#modal-body').text("Duplicate Username are not Allowed");
                        $('#userForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#myModal').modal('show');
                        $('#modal-body').text('User Added Successfully');
                        $('#userResult').load('serverside/manage-users.php');
                        $('#userForm').trigger('reset');
                    }
                }
            });

    });
    // update model invokation
    $('#userResult').on('click','.editUser',function(){
        $.ajax({
           url:'serverside/manage-users.php',
           type:'post',
            dataType:'json',
            data:{
               userid:$(this).attr('value'),
               actionString:'updateUser'
            },
        success:function(response){
            if(response==false)
            {
                $('#userUpdateModalBody').text('unable to update the use info');
                $('#userUpdateModal').modal('show');
            }
            else
            {
                $('#userUpdateModalBody .username').val(response[0].username);
                $('#userUpdateModalBody .password').val(response[0].password);
                $('#userUpdateModalBody .description').val(response[0].description);
                $('#userUpdateModalBody .privilage option').each(function(){
                   if($(this).attr('value')==response[0].privilage)
                       $(this).attr('selected','selected');
                });
                $('#userUpdateModal').modal('show');
            }
        }
        });
    });

    $('#updateUser').on('click',function(){
        var username = $(this).parents('form:first').find('.username');
        var password = $(this).parents('form:first').find('.password');
        var privilage = $(this).parents('form:first').find('.privilage');
        var description = $(this).parents('form:first').find('.description');


        $('#userUpdateForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (username.val().trim() == "")
            username.addClass('error');
        else if (password.val().trim() == "")
            password.addClass('error');
        else if (description.val().trim() == "")
            description.addClass("error");
        else
            $.ajax({
                url: "serverside/manage-users.php",
                type: 'post',
                data: {
                    username: username.val(),
                    password: password.val(),
                    description: description.val(),
                    privilage: privilage.val(),
                    actionString: 'updateUserInfo'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#userUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text("couldn't update the user");
                        $('#userForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#userUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text('User updated Successfully');
                        $('#userResult').load('serverside/manage-users.php');
                        $('#userForm').trigger('reset');
                    }
                }
            });

    });




});



