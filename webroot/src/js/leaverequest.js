$(document).ready(function() {



// $("#leaveType option:first").attr("value", "blahblah");


    $('.emp-list-leave-report').select2();
    $('.mydatepicker, #datepicker').on('changeDate', function(ev){
        $(this).datepicker('hide');
        $('#halfDay option').eq(0).prop('selected', true);
    });

    // auto calculations for finding the number of days
    $("#dateTo").change(function(){
        autoCalculateNoOfDays();
    });
    $("#dateFrom").change(function(){
        autoCalculateNoOfDays();
    });

    // for checking "date to" is not greater then "date from"
    $("#dateTo").change(function(){
        autoCalculateNoOfDays();
        validateLwopLeave();
        var noOfDays = $('#noOfDays').val();
        if(noOfDays != '' && noOfDays <= 0){
            $("#dateTo").val('');
            $('#noOfDays').val(0);
        }else {
            $('#noOfDays').val(noOfDays);
        }
    });
    $("#dateFrom").change(function(){

        autoCalculateNoOfDays();
        validateLwopLeave();
        var noOfDays = $('#noOfDays').val();
        if(noOfDays != '' && noOfDays <= 0){
            $("#dateTo").val('');
            $('#noOfDays').val(0);
        }else {
            $('#noOfDays').val(noOfDays);
        }
    });

    //number of date validation according to leave type
    $("#dateTo").change(function(){

        var leaveType = $("#leaveType").val();
        var noOfDays= $("#noOfDays").val();
        var totalDays = 0;

        if (leaveType == 1){
            var sickRemaining = $('#sickRemaining').val();
            var sickTaken = $('#sickTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(sickTaken);

            if (parseFloat(noOfDays) > (parseFloat(sickRemaining))){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        } else if(leaveType == 2){
            var casualRemaining = $('#casualRemaining').val();
            var casualTaken = $('#casualTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(casualTaken);

            if (parseFloat(noOfDays) > parseFloat(casualRemaining)){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        } else if(leaveType == 4){
            var earnedRemaining = $('#earnedRemaining').val();
            var earnedTaken = $('#earnedTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(earnedTaken);

            if (parseFloat(noOfDays) > parseFloat(earnedRemaining)){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        } else if(leaveType == 5){
            var unplannedRemaining = $('#unplannedRemaining').val();
            var unplannedTaken = $('#unplannedTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(unplannedTaken);

            if (parseFloat(noOfDays) > parseFloat(unplannedRemaining)){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        } else if(leaveType == 6){
            var plannedRemaining = $('#plannedRemaining').val();
            var plannedTaken = $('#plannedTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(plannedTaken);

            if (parseFloat(noOfDays) > parseFloat(plannedRemaining)){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        } else if(leaveType == 7){
            var restrictedRemaining = $('#restrictedRemaining').val();
            var restrictedTaken = $('#restrictedTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(restrictedTaken);

            if (parseFloat(noOfDays) > parseFloat(restrictedRemaining)){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        } else if(leaveType == 8){
            var dayOffRemaining = $('#dayOffRemaining').val();
            var dayOffTaken = $('#dayOffTaken').val();
            totalDays = parseFloat(noOfDays) + parseFloat(dayOffTaken);

            if (parseFloat(noOfDays) > parseFloat(dayOffRemaining)){
                $('#noOfDays').val(0);
                $('#dateFrom').val('');
                $('#dateTo').val('');
                $('#myRemainingModal').modal({show:true});
            }
        }

    });

    //for cancellation the leave taken is getting decreased

    /*
     $('#CancelButton').click(function(){

     console.log("clicked");

     var leaveType = $("#leaveType").val();
     var noOfDays= $("#noOfDays").val();
     var totalDays = 0;

     if (leaveType == 1){
     var sickRemaining = $('#sickRemaining').val();
     var sickTaken = $('#sickTaken').val();
     totalDays = parseFloat(sickTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > (parseFloat(sickRemaining))){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     } else if(leaveType == 2){
     var casualRemaining = $('#casualRemaining').val();
     var casualTaken = $('#casualTaken').val();
     totalDays = parseFloat(casualTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > parseFloat(casualRemaining)){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     } else if(leaveType == 4){
     var earnedRemaining = $('#earnedRemaining').val();
     var earnedTaken = $('#earnedTaken').val();
     totalDays = parseFloat(earnedTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > parseFloat(earnedRemaining)){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     } else if(leaveType == 5){
     var unplannedRemaining = $('#unplannedRemaining').val();
     var unplannedTaken = $('#unplannedTaken').val();
     totalDays = parseFloat(unplannedTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > parseFloat(unplannedRemaining)){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     } else if(leaveType == 6){
     var plannedRemaining = $('#plannedRemaining').val();
     var plannedTaken = $('#plannedTaken').val();
     totalDays = parseFloat(plannedTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > parseFloat(plannedRemaining)){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     } else if(leaveType == 7){
     var restrictedRemaining = $('#restrictedRemaining').val();
     var restrictedTaken = $('#restrictedTaken').val();
     totalDays = parseFloat(restrictedTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > parseFloat(restrictedRemaining)){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     } else if(leaveType == 8){
     var dayOffRemaining = $('#dayOffRemaining').val();
     var dayOffTaken = $('#dayOffTaken').val();
     totalDays = parseFloat(dayOffTaken) - parseFloat(noOfDays);

     if (parseFloat(noOfDays) > parseFloat(dayOffRemaining)){
     $('#noOfDays').val(0);
     $('#dateFrom').val('');
     $('#dateTo').val('');
     $('#myRemainingModal').modal({show:true});
     }
     }
     });
     */

    // for adding validations for leave days.
    $("#sick-leave").change(function(){
        var sickLeave = $("#sick-leave").val();
        if(sickLeave > 30){
            $("#sick-leave").val(0);
            alert("Sick leave cannot be greater then 7days");
        }
        console.log("this file called");
    });
    $("#casual-leave").change(function(){
        var casualLeave = $("#casual-leave").val();
        if(casualLeave > 60){
            $("#casual-leave").val(0);
            alert("Casual leave cannot be greater then 12days(inclusive carry)");
        }
    });
    $("#unplanned-leave").change(function(){
        var unplannedLeave = $("#unplanned-leave").val();
        if(unplannedLeave > 27){
            $("#unplanned-leave").val(0);
            alert("Unplanned leave cannot be greater then 7days");
        }
    });
    $("#planned-leave").change(function(){
        var plannedLeave = $("#planned-leave").val();
        if(plannedLeave > 23){
            $("#planned-leave").val(0);
            alert("Planned leave cannot be greater then 23days(inclusive carry)");
        }
    });
    $("#restricted-leave").change(function(){
        var restricted_leave = $("#restricted-leave").val();
        if(restricted_leave > 3){
            $("#restricted-leave").val(0);
            alert("Restricted leave cannot be greater then 3days");
        }
    });
    $("#day-off").change(function(){
        var day_off = $("#day-off").val();
        if(day_off > 18){
            $("#day-off").val(0);
            alert("Day Off leave cannot be greater then 18days");
        }
    });
    $('#halfDay').change(function(){
        autoCalculateNoOfDays();
        var no_of_days = $('#noOfDays').val();
        var halfDayVal = $(this).val();
        if(halfDayVal != "0"){
            $('#noOfDays').val(0.5 * no_of_days);
        } else if(halfDayVal == 0) {
            no_of_days = $('#noOfDays').val();
            $('#noOfDays').val(no_of_days);
        }
    });


    $('select#employee-id').change(function(){
        var currentVal = $(this).val();
       console.log(currentVal);
        if(currentVal != ''){
            $.ajax({
                type: "POST",
                url: "/emp-leaves/officeLocation",
                data: { empId: currentVal },
                cache: false,
                beforeSend: function(){
                    $('div#leave_type').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Employee Office Location" />'
                    );
                },
                success: function(html){
                    if(html == 'Error')
                    {
                        window.location.href = "/employees/dashboard";
                    }
                    else
                    {
                        $('div#leave_type').html(html);
                    }
                    
                } 
           });
        } else if(currentVal == ''){
            // return false;
            // window.location.href = "/employees/dashboard";
            $.ajax({
                type: "POST",
                url: "/emp-leaves/officeLocation",
                data: { empId: currentVal },
                cache: false,
                beforeSend: function(){
                    $('div#leave_type').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Employee Office Location" />'
                    );
                },
                success: function(html){    
                    window.location.href = "/employees/dashboard";
                } 
           });
        }
    });
    $('select#employee-id').change(function(){
        var currentVal = $(this).val();
        if(currentVal != ''){
            $.ajax({
                type: "POST",
                url: "/emp-leaves/reliever",
                data: { empId: currentVal },
                cache: false,
                beforeSend: function(){
                    $('div#reliever').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Employee Office Location" />'
                    );
                },
                success: function(html){
                    $('div#reliever').html(html);
                }
            });
        } else {
            return false;
        }
    });

    $('select#employee-id').change(function(){
        var currentVal = $('select#employee-id').val();
        if(currentVal != ''){
            $.ajax({
                type: "POST",
                url: "/emp-leaves/leaveTaken",
                data: { empId: currentVal },
                cache: false,
                beforeSend: function(){
                    $('div#leave_taken').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                    );
                },
                success: function(html){
                    $('div#leave_taken').html(html);
                }
            });
        } else {
            return false;
        }
    });

    $(document).on('change', "#leaveType", function(e){
        var leaveType = $('#leaveType').val();
        var officeLocation = $('#officeLocation').val();
        var sickRemaining = $('#sickRemaining').val();
        var casualRemaining = $('#casualRemaining').val();
        var earnedRemaining = $('#earnedRemaining').val();
        var plannedRemaining = $('#plannedRemaining').val();
        var unplannedRemaining = $('#unplannedRemaining').val();
        var restrictedRemaining = $('#restrictedRemaining').val();
        var dayOffRemaining = $('#dayOffRemaining').val();
        leaveTypeValidation(leaveType, officeLocation, sickRemaining, casualRemaining, earnedRemaining, plannedRemaining, unplannedRemaining, restrictedRemaining,dayOffRemaining);
    });

    function leaveTypeValidation(leaveType, officeLocation, sickRemaining, casualRemaining, earnedRemaining, plannedRemaining, unplannedRemaining, restrictedRemaining,dayOffRemaining){

        if (leaveType == 3){
            if (officeLocation == "SYL" || officeLocation == "DHK" || officeLocation == "NYC" ){
                if((sickRemaining != 0) || (casualRemaining != 0) || (earnedRemaining != 0)){
                    alert("You are not applicable for LWOP leave since you already have Sick/Casual/Earned Leave remaining!");
                    $('#leaveType').val('');
                }
            }
            if (officeLocation == "GOA"){
                if(plannedRemaining != 0 || unplannedRemaining != 0 || restrictedRemaining !=0){
                    alert("You are not applicable for LWOP leave since you already have Planned/Un-Planned/Restricted Leave remaining!");
                    $('#leaveType').val('');
                }
            }
            if (officeLocation == "UKR") {
                if(dayOffRemaining != 0){
                    alert("You are not applicable for LWOP leave since you already have Day-off remaining!");
                    $('#leaveType').val('');
                }
            }

        }
    }

    function autoCalculateNoOfDays(){
        var minutes = 1000 * 60;
        var hours = minutes * 60;
        var days = hours * 24;

        var dateFromVal = $('#dateFrom').val();
        if(dateFromVal == ""){
            $('#halfDay option').eq(0).prop('selected', true);
            return;
        }

        var dateToVal = $('#dateTo').val();
        if(dateToVal == ""){
            $('#halfDay option').eq(0).prop('selected', true);
            return;
        }


        var dF= Date.parse($("#dateFrom").val());
        var dateFrom = Math.round(dF/days);


        var dT= Date.parse($("#dateTo").val());
        var dateTo = Math.round(dT/days);

        var noOfDays = getBusinessDatesCount($("#dateFrom").val(), $("#dateTo").val());
        $('#noOfDays').val(noOfDays);
        //$('#reliever').val('');
    }

    function validateLwopLeave(){
        var minutes = 1000 * 60;
        var hours = minutes * 60;
        var days = hours * 24;

        var dateFromVal = $('#dateFrom').val();
        if(dateFromVal == ""){
            $('#halfDay option').eq(0).prop('selected', true);
            return;
        }

        var dateToVal = $('#dateTo').val();
        if(dateToVal == ""){
            $('#halfDay option').eq(0).prop('selected', true);
            return;
        }


        var dF= Date.parse($("#dateFrom").val());
        var dateFrom = Math.round(dF/days);


        var dT= Date.parse($("#dateTo").val());
        var dateTo = Math.round(dT/days);

        var noOfDays = getBusinessDatesCount($("#dateFrom").val(), $("#dateTo").val());
        $('#noOfDays').val(noOfDays);
    }

    function getBusinessDatesCount(startDate, endDate) {
        var count = 0;
        var curDate = new Date(startDate);
        var andDate = new Date(endDate);
        while (curDate <= andDate) {
            var dayOfWeek = curDate.getDay();
            if(!((dayOfWeek == 6) || (dayOfWeek == 0)))
                count++;
            curDate.setDate(curDate.getDate() + 1);
        }
        return count;
    }

    $('document').on('change', '#reliever',function(e){
        calcualteHalfLWOP();
    });

    function calcualteHalfLWOP(){
        var leaveType = $('#leaveType').val();
        var lwopTaken = $('#lwopTaken').val();
        var NOD = $('#noOfDays').val();
        var halfDay = $('#halfDay').val();
        var totalLwopLeaves = 0;
        if(leaveType == 3){
            if(halfDay == 1 || halfDay ==2){
                totalLwopLeaves = parseFloat(lwopTaken) + parseFloat(NOD);
                if(totalLwopLeaves > 20){
                    alert("You are not applicable to take more then 20 LWoP Leaves.");
                    $('#noOfDays').val(0);
                    $('#dateTo').val('');
                    $('#reliever').val('');
                }
            } else {
                totalLwopLeaves = parseFloat(lwopTaken) + parseFloat(NOD);
                if(totalLwopLeaves > 20){
                    alert("You are not applicable to take more then 20 LWoP Leaves.");
                    $('#noOfDays').val(0);
                    $('#dateTo').val('');
                    $('#reliever').val('');
                }
            }
        }
    }

    $("select#emp-list-leave-report").change(function(){
        var employeeId = $(this).val();
        if(employeeId != ''){
            $.ajax({
                type: "POST",
                url: "/emp-leaves/getLeaveType",
                data: { empId: employeeId },
                cache: false,
                beforeSend: function(){
                    $('div#office-locationwise-leave-type').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                    );
                },
                success: function(html){
                    $('div#office-locationwise-leave-type').html(html);
                }
            });
        } else {
            return false;
        }
    });

    $("button#btn-leave-report-search").click(function(){
        var dateTo = $("#dateTo").val();
        var dateFrom = $("#dateFrom").val();
        var empId = $("select#emp-list-leave-report").val();
        var leaveType = $("select#leaveType").val();
        if(dateTo == '' || dateFrom == '' || empId == ''){
            alert('Please select a date, or Employee or Leave Type');
            return false;
        } else {
            $.ajax({
                type: "GET",
                url: "/emp-leaves/getFilteredLeaves",
                data: { dateFrom: dateFrom, dateTo: dateTo, empId: empId, leaveType: leaveType },
                cache: false,
                beforeSend: function(){
                    $('div#leave-request-list').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                    );
                },
                success: function(html){
                    $('div#leave-request-list').html(html);
                }
            });
        }
    });

    // written by anik to work pagination in leave report
    $(document).on('click', '#pagination_leave_report a', function(e) {
        e.preventDefault();

        var $link = $(this);
        console.log($link);
        $.ajax({
            url: $link.attr('href'),
            beforeSend: function(){
                $('div#leave-request-list').html(
                    '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                );
            }
        }).done(function(html) {

            var $html;

            // grab Ajax response into jQuery object
            $html = $(html);

            // replace table body content with new <tr> elements
            $('div#leave-request-list').html($html);

            // replace pagination
            //$('.pagination').replaceWith($html.find('#pagination_leave_report').children());
        }).fail(function() {

            // if Ajax request fails fall back to just loading the target page
            window.location.href = $link.attr('href');

        });

    });//end written by anik

    $("button#btn-branch-leave-report-search").click(function(){
        var dateTo = $("#dateTo").val();
        var dateFrom = $("#dateFrom").val();
        var branch = $("select#branch-location-request-dropdown").val();
        var leaveType = $("select#leaveType").val();

        if(dateTo == '' || dateFrom == '' || branch == ''){
            alert('Please select a date, or office location or Leave Type');
            return false;
        } else {
            $.ajax({
                type: "GET",
                url: "/emp-leaves/getBranchwiseFilteredLeaves",
                data: { dateFrom: dateFrom, dateTo: dateTo, branch: branch, leaveType: leaveType },
                cache: false,
                beforeSend: function(){
                    $('div#leave-request-list').html(
                        '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                    );
                },
                success: function(html){
                    $('div#leave-request-list').html(html);
                }
            });
        }
    });

    // written by anik to work pagination in leave report
    $(document).on('click', '#pagination_branch_wise_leave_report a', function(e) {
        e.preventDefault();

        var $link = $(this);
        console.log($link);
        $.ajax({
            url: $link.attr('href'),
            beforeSend: function(){
                $('div#leave-request-list').html(
                    '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                );
            }
        }).done(function(html) {

            var $html;

            // grab Ajax response into jQuery object
            $html = $(html);

            // replace table body content with new <tr> elements
            $('div#leave-request-list').html($html);

            // replace pagination
            //$('.pagination').replaceWith($html.find('#pagination_leave_report').children());
        }).fail(function() {

            // if Ajax request fails fall back to just loading the target page
            window.location.href = $link.attr('href');

        });

    });//end written by anik

    $("button#btn-leave-report-export").click(function(){
        var employee_report_type = $('#employee-report-type').val();
        if(employee_report_type == ""){
            alert('Please select a Report Type');
            return false;
        }

        var dateTo = $("#dateTo").val(), dateFrom = $("#dateFrom").val(), employeeName = $("select#emp-list-leave-report").val();
        var leaveType = $("select#leaveType").val();
        var empId = $("select#emp-list-leave-report").val();

        if ("" == dateTo || "" == dateFrom || "" == employeeName) return alert("Please select a date, or Employee or Leave Type"), !1;

        else if(employee_report_type == 3){  //Creating PDF
            dateTo = $("#dateTo").val();
            dateFrom = $("#dateFrom").val();
            empId = $("select#emp-list-leave-report").val();
            leaveType = $("select#leaveType").val();

            if(dateTo == '' || dateFrom == '' || empId == ''){
                alert('Please select a date, or Employee or Leave Type');
                return false;
            } else {
                $.ajax({
                    type: "GET",
                    url: "/emp-leaves/getFilteredLeavesForPdf",
                    data: { dateFrom: dateFrom, dateTo: dateTo, empId: empId, leaveType: leaveType },
                    cache: false,
                    beforeSend: function(){
                        $('div#leave-request-list-for-pdf-downloading').html(
                            '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                        );
                    },
                    success: function(html){
                        $('div#leave-request-list-for-pdf-downloading').html(html);
                        demoFromHTMLPdfDownload();
                    }
                });
            }
            //demoFromHTML();
        } else {
            var fileType = '';
            if(employee_report_type == 1){
                fileType = 'xls';
            } else if(employee_report_type == 2){
                fileType = 'csv';
            }
            dateTo = $("#dateTo").val();
            dateFrom = $("#dateFrom").val();
            empId = $("select#emp-list-leave-report").val();
            leaveType = $("select#leaveType").val();
            if(dateTo == '' || dateFrom == '' || empId == ''){
                alert('Please select a date, or Employee or Leave Type');
                return false;
            }
            //var url = "/emp-leaves/downloadLeaveReport/" + dateFrom.replace(/\//g, "-") + "/" + dateTo.replace(/\//g, "-") + "/" + empId + "/" + "all" + "/" + fileType;
            //window.location.href = url;

            else if(leaveType == "") {
                var url = "/emp-leaves/downloadLeaveReport/" + dateFrom.replace(/\//g, "-") + "/" + dateTo.replace(/\//g, "-") + "/" + empId + "/" + "all" + "/" + fileType;
                window.location.href = url;
            }

            else {
                var url2 = "/emp-leaves/downloadLeaveReport/" + dateFrom.replace(/\//g, "-") + "/" + dateTo.replace(/\//g, "-") + "/" + empId + "/" + leaveType + "/" + fileType;
                window.location.href = url2;
            }
        }
    });

    $("button#btn-branch-leave-report-export").click(function(){
        var employee_report_type = $('#employee-report-type').val();
        if(employee_report_type == ""){
            alert('Please select a Report Type');
            return false;
        }
        var dateTo = $("#dateTo").val(), dateFrom = $("#dateFrom").val(), branchName = $("select#branch-location-request-dropdown").val();

        if ("" == dateTo || "" == dateFrom || "" == branchName) return alert("Please select a date and branch"), !1;

        else if(employee_report_type == 3){  //Creating PDF
            dateTo = $("#dateTo").val();
            dateFrom = $("#dateFrom").val();
            var branch = $("select#branch-location-request-dropdown").val();
            var leaveType2 = $("select#leaveType").val();

            if(dateTo == '' || dateFrom == '' || branch == ''){
                alert('Please select a date, or Employee or Leave Type');
                return false;
            } else {
                $.ajax({
                    type: "GET",
                    url: "/emp-leaves/getBranchFilteredLeavesForPdf",
                    data: { dateFrom: dateFrom, dateTo: dateTo, branch: branch, leaveType: leaveType2 },
                    cache: false,
                    beforeSend: function(){
                        $('div#leave-request-list-for-pdf-downloading').html(
                            '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
                        );
                    },
                    success: function(html){
                        $('div#leave-request-list-for-pdf-downloading').html(html);
                        demoFromHTMLPdfDownload();
                    }
                });
            }
            //demoFromHTML();
        } else {
            var fileType = '';
            if(employee_report_type == 1){
                fileType = 'xls';
            } else if(employee_report_type == 2){
                fileType = 'csv';
            }
            dateTo = $("#dateTo").val();
            dateFrom = $("#dateFrom").val();
            var branchId = $("select#branch-location-request-dropdown").val();
            var leaveType = $("select#leaveType").val();
            if(dateTo == '' || dateFrom == '' || branchId == ''){
                alert('Please select a date, or Employee or Leave Type');
                return false;
            } else if(leaveType == "") {
                var url2 = "/emp-leaves/downloadBranchwiseLeaveReport/" + dateFrom.replace(/\//g, "-") + "/" + dateTo.replace(/\//g, "-") + "/" + branchId + "/" + "all" + "/" + fileType;
                window.location.href = url2;
            }

            else {
                var url = "/emp-leaves/downloadBranchwiseLeaveReport/" + dateFrom.replace(/\//g, "-") + "/" + dateTo.replace(/\//g, "-") + "/" + branchId + "/" + leaveType + "/" + fileType;
                window.location.href = url;
            }
            // else {
            //     var url = "/emp-leaves/downloadBranchwiseLeaveReport/" + dateFrom.replace(/\//g, "-") + "/" + dateTo.replace(/\//g, "-") + "/" + branchId + "/" + leaveType + "/" + fileType;
            //     window.location.href = url;
            // }
        }
    });


//my code
    $('#search').keyup(function(){
        var searchKey = $(this).val();
        console.log(searchKey);
        searchEmployeesLeave ( searchKey );
    });

    function searchEmployeesLeave( keyword )
    {
        var data = keyword;
        $.ajax({
            method : 'get',
            url : "<?php echo $this->Url->build( ['controller' => 'EmpLeaves','action' => 'index' ] ); ?>",
            data : {keyword : data},

            succcess: function ( data )
            {
                $('div#leave-request').html( data );
            }
        });
    }


    
    $('#attendance-search').keyup(function(){
        var searchKey = $(this).val();
        console.log(searchKey);
       // searchEmployeesLeave ( searchKey );
    });



});

function demoFromHTML() {
    var dateobj = new Date();
    var B = dateobj.getDate().toString() + (dateobj.getMonth() + 1).toString() + dateobj.getFullYear().toString() + dateobj.getHours().toString() + dateobj.getMinutes().toString() + dateobj.getSeconds().toString();
    var pdf = new jsPDF('l', 'pt', 'letter');
    source = $('div#leave-request-list')[0];

    specialElementHandlers = {
        '#bypassme': function (element, renderer) {
            return true;
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 10,
        width: 1000
    };

    pdf.fromHTML(
        source,
        margins.left,
        margins.top, {
            'width': margins.width,
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            pdf.save(B + '.pdf');
        }, margins);
}

function demoFromHTMLPdfDownload() {
    var dateobj = new Date();
    var B = dateobj.getDate().toString() + (dateobj.getMonth() + 1).toString() + dateobj.getFullYear().toString() + dateobj.getHours().toString() + dateobj.getMinutes().toString() + dateobj.getSeconds().toString();
    var pdf = new jsPDF('l', 'pt', 'letter');
    source = $('div#leave-request-list-for-pdf-downloading')[0];

    specialElementHandlers = {
        '#bypassme': function (element, renderer) {
            return true;
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 10,
        width: 1000
    };

    pdf.fromHTML(
        source,
        margins.left,
        margins.top, {
            'width': margins.width,
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            pdf.save(B + '.pdf');
        }, margins);
}

function getBranchwiseLeaveType(){
    $.ajax({
        type: "POST",
        url: "/emp-leaves/getBranchwiseLeaveType",
        data: { officeLocation: $('#branch-location-request-dropdown').val() },
        cache: false,
        beforeSend: function(){
            $('div#office-locationwise-leave-type').html(
                '<img src="/img/spinner.gif" style="height: 32px; width: 32px; text-align: center;" alt="Loading.." title="Leaves Taken" />'
            );
        },
        success: function(html){
            $('div#office-locationwise-leave-type').html(html);
        }
    });
}