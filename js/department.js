
$(document).ready(function() {
    // loading users
    $('#departmentResult').load('serverside/manage-departments.php');

// deleting users
    $('#departmentResult').on('click','.deleteDepartment',function(){
        var departmentId=$(this).attr('value');
        $.ajax({
            url:'serverside/manage-departments.php',
            method:'post',
            data: {
                departmentId:departmentId,
                actionString:'deleteDepartment'
            },
            success: function(response) {
                if(response.trim()==true)
                {
                    $('#modal-body').text('Department deleted successfully');
                    $('#myModal').modal('show');
                    $('#departmentResult').load('serverside/manage-departments.php');
                }
                else
                {
                    $('#myModal').modal('show');
                    $('#modal-body').html('Failed to delete the Department.<br> It seems the Department is associated to a particular Section');
                }
            }
        })
    });

    // save button request of add new user modal
    $('#addDepartment').on('click', function() {
        var departmentName = $('#department-name');
        var userId = $('#userid');

        $('#departmentForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (departmentName.val().trim() == "")
            departmentName.addClass('error');
        else
            $.ajax({
                url: "serverside/manage-departments.php",
                type: 'post',
                data: {
                    departmentName: departmentName.val(),
                    userId: userId.val(),
                    actionString: 'addDepartment'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#myModal').modal('show');
                        $('#modal-body').text("Duplicate Department Name are not Allowed");
                        $('#departmentForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#myModal').modal('show');
                        $('#modal-body').text('Department Added Successfully');
                        $('#departmentResult').load('serverside/manage-departments.php');
                        $('#departmentForm').trigger('reset');
                    }
                }
            });

    });
    // update model invokation
    $('#departmentResult').on('click','.editDepartment',function(){
        $.ajax({
            url:'serverside/manage-departments.php',
            type:'post',
            dataType:'json',
            data:{
                departmentId:$(this).attr('value'),
                actionString:'updateDepartment'
            },
            success:function(response){
                if(response==false)
                {
                    $('#departmentUpdateModalBody').text('unable to update the Department info');
                    $('#departmentUpdateModal').modal('show');
                }
                else
                {
                    $('#departmentUpdateModalBody .departmentName').val(response[0].departmentName);
                    $('#departmentUpdateModalBody .departmentId').val(response[0].departmentId);
                    $('#departmentUpdateModalBody #userId option').each(function(){
                        if($(this).attr('value')==response[0].userId)
                            $(this).attr('selected','selected');
                    });
                    $('#departmentUpdateModal').modal('show');
                }
            }
        });
    });

    $('#updateDepartment').on('click',function(){
        var departmentName = $(this).parents('form:first').find('.departmentName');
        var userid = $(this).parents('form:first').find('#userId');
        var departmentId = $(this).parents('form:first').find('.departmentId');
        $('#departmentUpdateForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (departmentName.val().trim() == "")
            departmentName.addClass('error');
        else
            $.ajax({
                url: "serverside/manage-departments.php",
                type: 'post',
                data: {
                    departmentName: departmentName.val(),
                    userId: userid.val(),
                    departmentId:departmentId.val(),
                    actionString: 'updateDepartmentInfo'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#departmentUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text("couldn't update the Department");
                        $('#departmentForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#departmentUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text('User updated Successfully');
                        $('#departmentResult').load('serverside/manage-departments.php');
                        $('#departmentForm').trigger('reset');
                    }
                }
            });

    });




});



