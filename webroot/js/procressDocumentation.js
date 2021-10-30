$('document').ready(function(){
    var role=$("#selectedrole").val();
    var office=$("#selectedoffice").val();
    var  tags=$("#selectedtags").val(); 
    
    if(role !==undefined && role!=null) {
    var rolesarr=role.split(",");
        for(var i=0;i<rolesarr.length;i++) {
        $("#rolesofuser option[value='"+rolesarr[i]+"']").attr("selected",'selected');
        } 
    }

    if(office !==undefined && office!=null) {
    var officearray=office.split(",");
        for(var i=0;i<officearray.length;i++) {
            $("#office option[value='"+officearray[i]+"']").attr("selected",'selected');
        } 
    }

    if(tags !==undefined && tags!=null){
        var tagssarr=tags.split(",");
            for(var i=0;i<tagssarr.length;i++){
            $("#tags option[value='"+tagssarr[i]+"']").attr("selected",'selected');
            } 
        }
   
        $('#office').select2()
        $('#rolesofuser').select2()
        $("#roles").select2();
        $("#tags").select2();
        $("#process_id").select2();
        tinymce.init({
            selector: "textarea#processdescription",
            theme: "modern",
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons"
        });

    $("#addcontact").on('submit',function(){
        $('#processsubmit').attr('disabled','disabled');
    })

    $("#process_id").on('change',function(){
        var val=$(this).val();
        var employee=$("#employee_id").val();
        if(val.length>0)
        {
           $.ajax({
              type:'post',
              url:'/process_documentations/get_already_assigned_processes',
              data:{selected:val,employee:employee},
              success:function(data){
                  data.map( ({process_id}) => {
                      $("#process_id option[value="+process_id+"]:selected").attr("selected", false);
                  })
                    if(data.length>0){ 
                        $("#process_id").select2("destroy");
                        $("#process_id").select2();
                        alert("Some of the seleted processes have been already been assigned to the employee ");
                    }
                  },
              error:function(){
              }
          }); 
        }
    })

    $("#employee_id").on('change',function(){
        var eid=$(this).val()
        var office=$("#offices").val();
         if(eid.length>0){  console.log(eid);
             $("#loader").css("display","block");    
             $.ajax({
                type:'POST',
                url:'./get_department_processes',
                data:{employee_id:eid,office:office},
                success:function(data){
                    var status=data.status;
                    var responseData=data.data;
                    if(status>0){
                        var options="";
                        responseData.filter(({id,title,assign_processes})=>{
                            if((assign_processes.length == 0) || (assign_processes.length>0 && assign_processes[0].employee_id!=eid)){
                                options+='<option value='+id+'>'+title+'</option>';
                            }
                        }) 
                            $("#process_id").html(options);
                           
                    }  
                    $("#loader").css("display","none");         
                }
            });  
         }else{
         }
    })

    $("#AssignProcesses").on('submit',function(){
        var val=$('#process_id').val();
        var employee=$("#employee_id").val();
        var office=$("#offices").val();
            if(employee.length>0){
                if(val.length>0){
                        $("#processsubmit").attr('disabled','disabled')
                        return true
                }else{
                    alert("Please select a process to assign to the employee");
                    return false;
                }
            }else{
                    alert("Please enter an employee to whom you wish to assign the process to.");
                    return false;
                }
    });

    $("#addProcess").on('submit',function(){
          var val=$(this).serializeArray();
          var description=$("#processdescription").text(); 
          if(val.length>0){
            if(val[6] !=undefined){
                var count=($(val[6].value).text().trim().length)
                    if(val[6].name=='description' && (count<=0)){
                        alert("Please add description for the process");
                        return false;
                    }else{
                        $("#processsubmit").attr('disabled','disabled')
                    } 
                }else {
                    alert("Please add description for the process");
                    return false;
                }
          }
          $("#processsubmit").attr('disabled','disabled')
    });

    $("#deleteAssignedProcess").on('click',function(){
    });

    $("#editProcessDocumentation").submit(function(e){
            var val=$(this).serializeArray();
            if(val.length>0){
                if(val[6] !=undefined){
                    var count=($(val[6].value).text().trim().length)
                    if(val[6].name=='description' &&  (count<=0)){
                        alert("Please add description for the process");
                        return false;
                    }else{
                        $("#processsubmit").attr('disabled','disabled')
                    } 
                }else {
                    alert("Please add description for the process");
                    return false;
                }
            }
            $("#processsubmit").attr('disabled','disabled')
    });


  $(".tagForm").submit(function(e){
     var value=$("#tag").val().trim();
   // var patt = new RegExp(/[0-9]+$/);
     if(value.length<=0){
        $("#tag").val(""); 
        return false;
     }
     $("#tag").val(value);
     $("#processsubmit").attr("disabled",'disabled');
     return true
  });  


   $("#offices").change(function(){
      var value=$(this).val();
      $("#loader").css("display","block"); 
      $.ajax({
          url:'get_employee_from_office/'+value,
          type:'get',
          success:function(data){
              if(data.status==1){
                $("#employee_id").html(data.data);  
              } 
              $("#loader").css("display","none");  
          }
      });
      $.ajax({
        url:'get_office_procsss/'+value,
        type:'get',
        success:function(data){
            if(data.status==1){
               data=data.data;
               var options="";
               options+=data.map(({id,title}) => {
                return "<option value='"+id+"'>"+title+"</option>";
              });
              $("#process_id").html(options);
            }  
        }
    });
    
    // $("#loader").css("display","none"); 
   });
})
