$(document).ready(function(){
    var allowedExtensions=['png','jpg'];
    $('#skill-level-id').select2();
  
    $("#level-name").on('focusin',function(){
        $("#skill-level-submit").attr('disabled',true);
    })
  
    $("#level-name").on('focusout',function(){
        let value=$("#level-name").val();
        $.ajax({
            url:'check-skill-levels/'+value,
            success:function(data){
             let code=data.code;
                if(code==1){
                     alert(data.data+" already exist in skill level");
                     $("#skill-level-submit").attr('disabled',true);
                 }else{
                    $("#skill-level-submit").removeAttr('disabled');
                 }  
            }, 
        });  
    })
  
    $("#skill-name").on('focusin',function(){
        $("#skill-submit").attr('disabled',true);
    })

  $("#skill-name").on('focusout',function(){
    let value=$("#skill-name").val();
    $.ajax({
        url:'check-levels/'+value,
        success:function(data){
         let code=data.code;
            if(code==1){
                 alert(data.data+" already exist in skills ");
                 $("#skill-submit").attr('disabled',true);
             }else{
                $("#skill-submit").removeAttr('disabled');
             }  
        }, 
    });  
  })


    $("#skill-level").submit(function(){
        var code=0;
        let val=$("#level-name").val();
           if(val.trim().length>0){
                let value=val.split(",");
                if(value.length>0){
                }
           }else{
               alert("Please provide data for the field");
               return false;
           }
    });
    $("#skils").submit(function(){
        var skillName=$("#skill-name").val();
        var skillLevelId=$("#skill-level-id").val();
        var version=$("#version").val();
        var image=$("#image").val();
        var format=image.split(".");
        var fileExtension=format[1].toLowerCase();
        var isValidFile=false;
        if(skillName.trim().length>0 && skillLevelId.length>0){
                if(format.length>0){
                    for(var index in allowedExtensions) {
                        if(fileExtension === allowedExtensions[index]) {
                            isValidFile = true; 
                            break;
                        }
                    }
                    if(!isValidFile){
                        alert("file format is not supported. Please upload jpg,png files only");
                        return false;
                    }
                }
        }else{
            alert("Please provide all the fields");
            return false;
        }
    });

    $("#reset-form").click(function(){
        $("#skils").trigger("reset");
        $("#skill-level-id option").prop("selected",false);
        $(".select2-selection__rendered").html("");
        $("#image-path").attr('src',"").hide();
    });
   
    function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('#image-path').attr('src', e.target.result).attr("style",'width:400px;height:200px;').show(); 
          }
          reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
      }
      
      $("#skill-image").change(function() {
        readURL(this);
      });

    $("a[id^=image_]").click(function(){
        let image=$(this).attr('data-image-url');
        $("#image-holder").attr('src',image);
        $(".imageModel").modal('show');
    })
})
    $('#skill-level-id').select2('destroy').find('option').prop('selected', 'selected').end().select2();

    $('.skills-cat').select2();

    /*-------------DO NOT DELETE BELOW CODE--------------------*/
    /* collapsible option group default open */
    // $("body").on('click', '.select2-results__group', function() {
    //     $(this).siblings().toggle();
    //   })

    /* collapsible option group default collapsed */
    // let optgroupState = {};
    // $("body").on('click', '.select2-container--open .select2-results__group', function() {
    //     $(this).siblings().toggle();
    //     let id = $(this).closest('.select2-results__options').attr('id');
    //     let index = $('.select2-results__group').index(this);
    //     optgroupState[id][index] = !optgroupState[id][index];
    //   })

    //   $('.skills-cat').on('select2:open', function() {
    //     $('.select2-dropdown--below').css('opacity', 0);
    //     setTimeout(() => {
    //       let groups = $('.select2-container--open .select2-results__group');
    //       let id = $('.select2-results__options').attr('id');
    //       if (!optgroupState[id]) {
    //         optgroupState[id] = {};
    //       }
    //       $.each(groups, (index, v) => {
    //         optgroupState[id][index] = optgroupState[id][index] || false;
    //         optgroupState[id][index] ? $(v).siblings().show() : $(v).siblings().hide();
    //       })
    //       $('.select2-dropdown--below').css('opacity', 1);
    //     }, 0);
    //   })
