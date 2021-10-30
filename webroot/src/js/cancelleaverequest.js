
$(document).ready(function() {

    $('#CancelButton').on('click', function(e){
        e.preventDefault();
        console.log("Hello");
        
        //for cancellation the leave taken is getting decreased

        // var leaveType = $("#leaveType").val();
        // var noOfDays= $("#noOfDays").val();
        // var totalDays = 0;

        // if (leaveType == 1){
        //     var sickRemaining = $('#sickRemaining').val();
        //     var sickTaken = $('#sickTaken').val();
        //     totalDays = parseFloat(sickTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > (parseFloat(sickRemaining))){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } else if(leaveType == 2){
        //     var casualRemaining = $('#casualRemaining').val();
        //     var casualTaken = $('#casualTaken').val();
        //     totalDays = parseFloat(casualTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > parseFloat(casualRemaining)){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } else if(leaveType == 4){
        //     var earnedRemaining = $('#earnedRemaining').val();
        //     var earnedTaken = $('#earnedTaken').val();
        //     totalDays = parseFloat(earnedTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > parseFloat(earnedRemaining)){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } else if(leaveType == 5){
        //     var unplannedRemaining = $('#unplannedRemaining').val();
        //     var unplannedTaken = $('#unplannedTaken').val();
        //     totalDays = parseFloat(unplannedTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > parseFloat(unplannedRemaining)){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } else if(leaveType == 6){
        //     var plannedRemaining = $('#plannedRemaining').val();
        //     var plannedTaken = $('#plannedTaken').val();
        //     totalDays = parseFloat(plannedTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > parseFloat(plannedRemaining)){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } else if(leaveType == 7){
        //     var restrictedRemaining = $('#restrictedRemaining').val();
        //     var restrictedTaken = $('#restrictedTaken').val();
        //     totalDays = parseFloat(restrictedTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > parseFloat(restrictedRemaining)){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } else if(leaveType == 8){
        //     var dayOffRemaining = $('#dayOffRemaining').val();
        //     var dayOffTaken = $('#dayOffTaken').val();
        //     totalDays = parseFloat(dayOffTaken) - parseFloat(noOfDays);

        //     if (parseFloat(noOfDays) > parseFloat(dayOffRemaining)){
        //         $('#noOfDays').val(0);
        //         $('#dateFrom').val('');
        //         $('#dateTo').val('');
        //         $('#myRemainingModal').modal({show:true});
        //     }
        // } 

    });
   
});