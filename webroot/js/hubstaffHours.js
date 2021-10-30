$('document').ready(function(){

    $("#hubstaffAttendence").change(function(){
        var ext = $(this).val().split('.').pop().toLowerCase();
        console.log(ext);
        if($.inArray(ext, ['csv']) == -1) {
            alert('You can only upload csv files!');
        }
    })
    
    $("#UpdateName").submit(function(){
        var name=$("#name").val().trim();
        var patt1 = new RegExp(/[!@#$%^&*(),;?":{}|<>0-9]/);
         if(name.length>0){
            if(patt1.test(name)){
                alert("Name field cannot have special charactors or numbers");
                $("#name").val("");
                return false;  
            }
        }else{
            alert("Please enter the employee Hubstaff name");
            $("#name").val("");
            return false;
        }
        return true;
    })  


    $("#office_lctn").change(function(){
        var office=$(this).val();
        $("#loader").css("display",'block');
        $.ajax({
            'type':'POST',
            'url':'../hubstaff-hours/get_employees_by_hubstaff_name',
            'data':{office:office},
            success:function(data){
                if(data.code==1){
                    $("#emploees").html(data.data);
                }
                $("#loader").css("display",'none');
            }
        })
    })



    $("#office_location").change(function(){
        var office=$(this).val();
        $("#loader").css("display",'block');
        $.ajax({
            'type':'POST',
            'url':'../hubstaff-hours/get_employees',
            'data':{office:office},
            success:function(data){
                if(data.code==1){
                    $("#emploees").html(data.data);
                }
                $("#loader").css("display",'none');
            }
        })
    })


    $("#editHubStaff").submit(function(){
         $("#hubstaffEdit").attr('disabled','disabled');
    });
   
    $('#UploadhubstaffCsv').submit(function(){
        if($('#hubstaffAttendence').val()) {
            $("#hubstaffEdit").attr('disabled','disabled');
        }else{
            return false;
        }
    })


    // $("#emploees").change(function(){
    //     var value=$(this).val();
    //     console.log(value);
    // });


    // $("#searchAttendence").submit(function(){
    //     var from=$("#from-date").val();
    //     var to=$("#to-date").val();
    //     if(from.length>0 || to.length >0){
    //         if(from.length <=0 ||  to.length<=0){
    //              alert("Please provide a date range");
    //              return false;
    //         }else{
    //             var g1 = new Date(from); 
    //             var g2 = new Date(to); 
    //             if(g1 > g2 ){
    //                 alert("From date cannot more then to date");
    //                 return false;
    //             }
    //         }
    //     }
    //     return false;
    // })

})