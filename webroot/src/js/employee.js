$(document).ready(function() {
    jQuery('#dateFrom,#dateTo').datepicker({
        todayHighlight: true, daysOfWeekDisabled: [0,6]
    });
    jQuery('.mydatepicker').datepicker({
        todayHighlight: true
    });
    if ($("textarea#mymce").length > 0){
        tinymce.init({
            selector: "textarea#mymce",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons"
        });
    }

    $('select#office-location-emp-list').change(function(){
        var currentVal = $(this).val();
        if(currentVal != ''){
            $.ajax({
                type: "POST",
                url: "/employees/filter",
                data: { branch: currentVal },
                cache: false,
                beforeSend: function(){
                    $('div#emp-list-table').html(
                        '<tr><td colspan="5" style="text-align: center;"><img src="/img/ajaxloader.gif" style="" /></td></tr>'
                    );
                },
                success: function(html){
                    $('div#emp-list-table').html(html);
                } 
           });
        } else {
            return false;
        }
    });

    // set add employee form data in browser storeage
    $("a[href$='#next']").on('click',function(e){   
        if (typeof(Storage) !== "undefined") {
            localStorage.setItem("fisrtName", $('.first-name').val());
            localStorage.setItem("lastName", $('.last-name').val());
            localStorage.setItem("personalEmail", $('.personal-email').val());
            localStorage.setItem("officeEmail",  $('.office-email').val());
            localStorage.setItem("gender", $('.gender').val());
            localStorage.setItem("permanentAddress", $('.permanent-address').val());
            localStorage.setItem("presentAddress", $('.present-address').val());
            localStorage.setItem("country", $('.country').val());
            localStorage.setItem("officeLocation", $('.office-location').val());
            localStorage.setItem("mobileNumber", $('.mobile-number').val());
            localStorage.setItem("alternateNumber", $('.alternate-number').val());
            localStorage.setItem("emergencyNumber", $('.emergency-number').val());
            localStorage.setItem("birthDay", $('.birth-date').val());
            localStorage.setItem("martialStatus", $('.martial-status').val());
            localStorage.setItem("bloodGroup", $('.blood-group').val());
            localStorage.setItem("languages", $('.languages').val());
            localStorage.setItem("bankName", $('.bank-name').val());
            localStorage.setItem("bankAccountNumber", $('.bank-account-number').val());
            localStorage.setItem("taxBracket", $('.tax-bracket').val());
            localStorage.setItem("maxQualifaction", $('.max-qualification').val());
            localStorage.setItem("role", $('.role-id').val());
        }
    });


        // get office location by default and set office time
        var location = $('.office-location').val();
            setOfficeTime(location);
            setSessionValue(location);
            
        // get office location on changing location option
        $('select.office-location').on('change',function(){
            $("#shift-type-request").attr("id","shift-type");
            var location = $('.office-location').val();
            console.log(location);
            setOfficeTime(location);
        });

});

// set input field valu from browser storage 
function setSessionValue(value, id){
    if(value !== "undefined"){
        $(''+id).val(value);
    }
    else{
        $(''+id).val('');
    }
}

// set office time in offce time field depending on office location
function setOfficeTime(office){
    if(office == 'SYL'){
        $('#shift-type').empty();
        $('#shift-type').append($("<option selected/>").val("09:00 - 06:00").text("09:00 - 06:00"));
        $('#shift-type').append($("<option />").val("12:00 - 09:00").text("12:00 - 09:00"));
        $('#shift-type').append($("<option />").val("01:00 - 10:00").text("01:00 - 10:00"));
    }
    else if(office == 'NYC'){
        $('#shift-type').empty();
        $('#shift-type').append($("<option selected/>").val("06:00 - 15:00").text("06:00 - 15:00"));
        $('#shift-type').append($("<option />").val("08:00 - 16:00").text("08:00 - 16:00"));
    }
    else if(office == 'GOA'){
        $('#shift-type').empty();
        $('#shift-type').append($("<option selected/>").val("08:30 - 17:30").text("08:30 - 17:30"));
        $('#shift-type').append($("<option />").val("09:00 - 18:00").text("09:00 - 18:00"));
        $('#shift-type').append($("<option />").val("09:30 - 18:30").text("09:30 - 18:30"));
        $('#shift-type').append($("<option />").val("10:00 - 19:00").text("10:00 - 19:00"));
        $('#shift-type').append($("<option />").val("11:00 - 20:00").text("11:00 - 20:00"));
        $('#shift-type').append($("<option />").val("12:00 - 21:00").text("12:00 - 21:00"));
        $('#shift-type').append($("<option />").val("18:00 - 02:30").text("18:00 - 02:30"));
    }
    else if(office == 'DHK'){
        $('#shift-type').empty();
        $('#shift-type').append($("<option selected/>").val("07:30 - 15:00").text("07:30 - 15:00"));
        $('#shift-type').append($("<option />").val("15:30 - 23:00").text("15:30 - 23:00"));
    }
    else if(office == 'UKR'){
        $('#shift-type').empty();
        $('#shift-type').append($("<option selected/>").val("10:00 - 07:00").text("10:00 - 07:00"));
    }
}