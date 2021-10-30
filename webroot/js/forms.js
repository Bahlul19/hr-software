$(document).ready(function(){
    $("#access-roles").select2();
    $("#feedback-for").select2();
    $("#available_roles").select2();
    // $("#feedback-for option[value=0]").attr('disabled',true);
  

    var edit=$("#editpage").val();
    $("#access-roles").change(function(){
        var value=$("#access-roles").val();
        if(value.length>0){
            $("#feedback-for").attr("disabled",true);
        }else{
            $("#feedback-for").attr("disabled",false);
        }
    })
    $("#feedback-for").change(function(){
        var value=$("#feedback-for").val();
        if(value.length>0){
            $("#access-roles").attr("disabled",true);
        }else{
            $("#access-roles").attr("disabled",false);
        }
    });

   $("#submission-table input[type='checkbox']").click(function(){
       if($(this).is(":checked")){
          if(!confirm("The Employee will be able to see the form reponse given to him. Are you sure?")){
              return false;
          };
        }
           
      var is_visible=$(this).val()==1 ? 0:1;
      console.log(is_visible);
      var text= $(this).val()==1 ? "No":"Yes";
      var response_id=$(this).attr("data-submission");
      var that=$(this);
             $.ajax({
                   url:'/form-submissions/mark-form-response',
                   type:"post",
                   data:{is_visible,response_id},
                   success:function(data){
                         if(data.code==1){
                             alert(data.data);
                             $(that).parent().find("span").text(text);
                             $(that).val(is_visible);
                         }
                   },
                   error:function(er){
                     console.log(er);
                   }

            });
      })
   
     if(edit==1){
        $('#available_roles').on("select2:unselecting", function(e){
            if(confirm("Are you sure you want to delete this Role?")){
                return true;
            } else{
                    e.preventDefault();
                }  
        });

        $('#available_roles').on("select2:unselect", function(e){
            var role_id=e.params.data.id;
            var role_name=e.params.data.title;
            var form=$("#form").val();
                    $.ajax({
                        url:'/forms/remove-available-for',
                        type:"post",
                        data:{role_id,form},
                        success:function(data){
                            if(data.code==1){
                                alert(data.data);
                            }
                        },
                        error:function(er){
                        console.log(er);
                        }
                    })  
        }).trigger('change');

      //   var selected=1;
        $('#feedback-for,#access-roles').on("select2:unselecting", function(e){
            var id = $(this).attr('id');
            var type=$("#role-type").val();
            var selectedType=0;
            var name="";
           
            if(id=="feedback-for"){
                 name="Employee";
                 selectedType=1;
            }else{
                name="Role";
                selectedType=2;
            }
            console.log(id,type,selectedType);
            if(selectedType==type){
                if(confirm("Are you sure you want to delete this "+name+"?")){
                    return true;
                } else{
                        e.preventDefault();
                    }  
                }
        });

        $('#feedback-for,#access-roles').on("select2:unselect", function(e){
            var role_id=e.params.data.id;
            var role_name=e.params.data.title;
            var form=$("#form").val();
                    $.ajax({
                        url:'/forms/remove-feedback-for',
                        type:"post",
                        data:{role_id,form},
                        success:function(data){
                            if(data.code==1){
                                alert(data.data);
                            }
                        },
                        error:function(er){
                        console.log(er);
                        }
                    })  
        }).trigger('change');
    }

    $("#add-form,#edit-form").submit(function(e){
        var availableFrom= new Date($('#available-from').val()); 
        var availableTo= new Date($('#available-to').val());
        var availableRoles=$('#available_roles').val();
        var title=$("#title").val();
        var description=$("#description").val();
        var accessRoles=$("#access-roles").val();
        var feedbackFor=$("#feedback-for").val();
      
        if(title.trim().length==0){
            alert("Please enter a proper Title");
            $("#title").val("");
            return false;
        }else{
            title = title.trim().replace(/ +(?= )/g,'');
            $("#title").val(title);
        }  

        if(description.trim().length==0){
            alert("Please enter a proper Description");
            $("#description").val("");
            return false;
        }else{
            description = description.trim().replace(/ +(?= )/g,'');
            $("#description").val(description);
        }  

        if(isEmoji(title)){
            alert("Please enter proper Title");
            return false;
        }

        if(isEmoji(description)){
            alert("Please enter proper Description");
            return false;
        }

        if(accessRoles.length==0 && feedbackFor.length==0 ){
             alert("Please select Roles or Employees for the forms.");
             return false;
        }  
        if(availableFrom > availableTo){
           alert("Dates selected are incorrect, Please select proper dates");
           return false;
        }
        // else if(availableFrom == availableTo){
        //    alert("Please make sure there is atleast one day gap between the dates");
        //    return false;
        // }
  });


  function isEmoji(str) {
    var ranges = [
        '(?:[\u2700-\u27bf]|(?:\ud83c[\udde6-\uddff]){2}|[\ud800-\udbff][\udc00-\udfff]|[\u0023-\u0039]\ufe0f?\u20e3|\u3299|\u3297|\u303d|\u3030|\u24c2|\ud83c[\udd70-\udd71]|\ud83c[\udd7e-\udd7f]|\ud83c\udd8e|\ud83c[\udd91-\udd9a]|\ud83c[\udde6-\uddff]|[\ud83c[\ude01-\ude02]|\ud83c\ude1a|\ud83c\ude2f|[\ud83c[\ude32-\ude3a]|[\ud83c[\ude50-\ude51]|\u203c|\u2049|[\u25aa-\u25ab]|\u25b6|\u25c0|[\u25fb-\u25fe]|\u00a9|\u00ae|\u2122|\u2139|\ud83c\udc04|[\u2600-\u26FF]|\u2b05|\u2b06|\u2b07|\u2b1b|\u2b1c|\u2b50|\u2b55|\u231a|\u231b|\u2328|\u23cf|[\u23e9-\u23f3]|[\u23f8-\u23fa]|\ud83c\udccf|\u2934|\u2935|[\u2190-\u21ff])' // U+1F680 to U+1F6FF
    ];
    if (str.match(ranges.join('|'))) {
        return true;
    } else {
        return false;
    }
}
  // $(".get-data").css('visibility','hidden');

})



