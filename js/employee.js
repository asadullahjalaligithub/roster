
$(document).ready(function() {
    // loading users
    var globalSectionId = $('#sectionId').val();
    $('#employeeResult').load('serverside/manage-employee.php?sectionId='+globalSectionId);

// deleting users
    $('#employeeResult').on('click','.deleteEmployee',function(){
        var employeeId=$(this).attr('value');
        $.ajax({
            url:'serverside/manage-employee.php',
            method:'post',
            data: {
                employeeId:employeeId,
                actionString:'deleteEmployee'
            },
            success: function(response) {
                if(response.trim()==true)
                {
                    $('#modal-body').text('Employee deleted successfully');
                    $('#myModal').modal('show');
                    $('#employeeResult').load('serverside/manage-employee.php?sectionId='+globalSectionId);
                }
                else
                {
                    $('#myModal').modal('show');
                    $('#modal-body').html('Failed to delete the Employee.<br> It seems the employee is associated to some working hour');
                }
            }
        })
    });

    // save button request of add new user modal
    $('#addEmployee').on('click', function() {
        var employeeId = $('#employeeId');
        var employeeName = $('#employeeName');
        var employeeDesignation = $('#employeeDesignation');
        var sectionId = $('#sectionId');

        $('#employeeForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (employeeId.val().trim() == "")
            employeeId.addClass('error');
        else if (employeeName.val().trim() =="")
            employeeName.addClass('error');
        else if (employeeDesignation.val().trim() == "")
            employeeDesignation.addClass('error');
        else
            $.ajax({
                url: "serverside/manage-employee.php",
                type: 'post',
                data: {
                    employeeName: employeeName.val(),
                    sectionId: sectionId.val(),
                    employeeId:employeeId.val(),
                    employeeDesignation:employeeDesignation.val(),
                    actionString: 'addEmployee'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#myModal').modal('show');
                        $('#modal-body').text("Duplicate Employee Id is not Allowed");
                        $('#employeeForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#myModal').modal('show');
                        $('#modal-body').text('Employee Added Successfully');
                        $('#employeeResult').load('serverside/manage-employee.php?sectionId='+globalSectionId);
                        $('#employeeForm').trigger('reset');
                    }
                }
            });

    });
    // update model invokation
    $('#employeeResult').on('click','.editEmployee',function(){
        $.ajax({
            url:'serverside/manage-employee.php',
            type:'post',
            dataType:'json',
            data:{
                employeeId:$(this).attr('value'),
                actionString:'updateEmployee'
            },
            success:function(response){
                if(response==false)
                {
                    $('#employeeUpdateModalBody').text('unable to update the Employee info');
                    $('#employeeUpdateModal').modal('show');
                }
                else
                {
                    $('#employeeUpdateModalBody .employeeName').val(response[0].employeeName);
                    $('#employeeUpdateModalBody .employeeDesignation').val(response[0].employeeDesignation);
                    $('#employeeUpdateModalBody .employeeId').val(response[0].employeeId);
                    $('#employeeUpdateModal').modal('show');
                }
            }
        });
    });

    $('#updateEmployee').on('click',function(){
        var employeeName = $(this).parents('form:first').find('.employeeName');
        var employeeId = $(this).parents('form:first').find('.employeeId');
        var employeeDesignation = $(this).parents('form:first').find('.employeeDesignation');
        var sectionId = $(this).parents('form:first').find('#sectionId');
        $('#employeeUpdateForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (employeeName.val().trim() == "")
            employeeName.addClass('error');
      else  if (employeeDesignation.val().trim() == "")
            employeeDesignation.addClass('error');
      else  if (employeeId.val().trim() == "")
            employeeId.addClass('error');
        else
            $.ajax({
                url: "serverside/manage-employee.php",
                type: 'post',
                data: {
                    employeeName: employeeName.val(),
                    sectionId: sectionId.val(),
                    employeeDesignation:employeeDesignation.val(),
                    employeeId:employeeId.val(),
                    actionString: 'updateEmployeeInfo'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#employeeUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text("couldn't update the Employee");
                        $('#employeeForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#employeeUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text('Employee updated Successfully');
                        $('#employeeResult').load('serverside/manage-employee.php?sectionId='+globalSectionId);
                        $('#employeeForm').trigger('reset');
                    }
                }
            });

    });




});



