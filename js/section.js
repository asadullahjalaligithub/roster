
$(document).ready(function() {
    // loading users
    $('#sectionResult').load('serverside/manage-section.php');

// deleting users
    $('#sectionResult').on('click','.deleteSection',function(){
        var sectionId=$(this).attr('value');
        $.ajax({
            url:'serverside/manage-section.php',
            method:'post',
            data: {
                sectionId:sectionId,
                actionString:'deleteSection'
            },
            success: function(response) {
                if(response.trim()==true)
                {
                    $('#modal-body').text('Section deleted successfully');
                    $('#myModal').modal('show');
                    $('#sectionResult').load('serverside/manage-section.php');
                }
                else
                {
                    $('#myModal').modal('show');
                    $('#modal-body').html('Failed to delete the Section.<br> It seems the Section is associated to a particular Section');
                }
            }
        })
    });

    // save button request of add new user modal
    $('#addSection').on('click', function() {
        var sectionName = $('#sectionName');
        var departmentId = $('#departmentId');

        $('#sectionForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (sectionName.val().trim() == "")
            sectionName.addClass('error');
        else
            $.ajax({
                url: "serverside/manage-section.php",
                type: 'post',
                data: {
                    sectionName: sectionName.val(),
                    departmentId: departmentId.val(),
                    actionString: 'addSection'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#myModal').modal('show');
                        $('#modal-body').text("Duplicate Section Name are not Allowed");
                        $('#sectionForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#myModal').modal('show');
                        $('#modal-body').text('Section Added Successfully');
                        $('#sectionResult').load('serverside/manage-section.php');
                        $('#sectionForm').trigger('reset');
                    }
                }
            });

    });
    // update model invokation
    $('#sectionResult').on('click','.editSection',function(){
        $.ajax({
            url:'serverside/manage-section.php',
            type:'post',
            dataType:'json',
            data:{
                sectionId:$(this).attr('value'),
                actionString:'updateSection'
            },
            success:function(response){
                if(response==false)
                {
                    $('#sectionUpdateModalBody').text('unable to update the Section info');
                    $('#sectionUpdateModal').modal('show');
                }
                else
                {
                    $('#sectionUpdateModalBody .sectionName').val(response[0].sectionName);
                    $('#sectionUpdateModalBody .sectionId').val(response[0].sectionId);
                    $('#sectionUpdateModalBody #departmentId option').each(function(){
                        if($(this).attr('value')==response[0].departmentId)
                            $(this).attr('selected','selected');
                    });
                    $('#sectionUpdateModal').modal('show');
                }
            }
        });
    });

    $('#updateSection').on('click',function(){
        var sectionName = $(this).parents('form:first').find('.sectionName');
        var sectionId = $(this).parents('form:first').find('.sectionId');
        var departmentId = $(this).parents('form:first').find('#departmentId');
        $('#sectionUpdateForm').find("input").each(function() {
            $(this).removeClass('error');
        });
        if (sectionName.val().trim() == "")
            sectionName.addClass('error');
        else
            $.ajax({
                url: "serverside/manage-section.php",
                type: 'post',
                data: {
                    sectionName: sectionName.val(),
                    sectionId: sectionId.val(),
                    departmentId:departmentId.val(),
                    actionString: 'updateSectionInfo'
                },
                success: function (response) {
                    if (response.trim() == 'false') {
                        $('#sectionUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text("couldn't update the Section");
                        $('#sectionForm').trigger('reset');
                    } else if (response.trim() == 'true') {
                        $('#sectionUpdateModal').modal('hide');
                        $('#myModal').modal('show');
                        $('#modal-body').text('Section updated Successfully');
                        $('#sectionResult').load('serverside/manage-section.php');
                        $('#sectionForm').trigger('reset');
                    }
                }
            });

    });




});



