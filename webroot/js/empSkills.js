var mymaxDate = new Date();
jQuery('.skilldatepicker').datepicker({
    todayHighlight: true,
    format: 'yyyy-mm-dd',
    endDate: mymaxDate,
});

function pass(num,newRowNum,skillOp){
    $('#btn-'+num).css('display','none');
     $('#del-btn-'+num).css('display','none');
     var newRow = '<div class="row mb-3" id="row-'+ newRowNum +'"><div class="col-md-4">';

     newRow +='<select name="employeeSkill['+ newRowNum +'][skill_id]" class="form-control skills-cat-new-row" id="skill-select-'+newRowNum+'" onchange="getlevel('+ newRowNum +');"  required="required" id="employeeskill-'+ newRowNum +'-skill-id"><option value="">Choose</option>'+ skillOp;
     newRow += '</select></div><div class="col-md-2">';

     newRow +='<select name="employeeSkill['+ newRowNum +'][skill_level_id]" onchange="checkval('+ newRowNum +');" class="form-control" required="required" id="skill-levels-'+newRowNum+'"><option value="">Choose</option></select>';
     newRow += '</div><div class="col-md-2">';

     newRow += '<input type="text" name="employeeSkill['+ newRowNum +'][from_date]" class="form-control skilldatepicker-add" id="from_date" autocomplete="off" required="required">';
     newRow += '</div><div class="col-md-2">';

     newRow += '<input type="text" name="employeeSkill['+ newRowNum +'][to_date]" class="form-control skilldatepicker-add" id="to_date" autocomplete="off" required="required">';

     newRow +=' </div><div class="col-md-2 buttons-skill"><button class="btn" id="btn-'+ newRowNum +'" onclick="add('+ newRowNum +');"><i class="fa fa-plus"></i></button>';

     newRow +='<button class="btn" id="del-btn-'+ newRowNum +'" onclick="remove('+ newRowNum +');"><i class="fa fa-trash"></i></button></div>';

     newRow += '</div><div class="row mb-3 ml-1"><div id="error-'+ newRowNum +'"></div></div><div id="replace"></div>';

     $('#replace').replaceWith(newRow);

     jQuery('.skilldatepicker-add').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        endDate: mymaxDate,
    });

    $('.skills-cat-new-row').select2();
}

function remove(num){
    $('#row-'+num).replaceWith();
    $('#btn-'+(num-1)).css('display','inline-block');
    $('#del-btn-'+(num-1)).css('display','inline-block');
}

function getlevel(num) {
    var rownum=num;
    var skill = jQuery('#skill-select-'+rownum).val();
    jQuery.ajax({
        type: "POST",
        url: "/employee-skills/skill_level_select",
        data: {
            skill:skill,
        },
        dataType: "json",
        beforeSend: function(xhr) {
            xhr.setRequestHeader(
                "X-CSRF-Token",
                $('[name="_csrfToken"]').val()
            );
        },
        success: function(response) {
            if (!$.trim(response)) {
                alert(
                    "There are no skill levels selected for this skill."
                );
            }
            var skillLevelsList = '<option value="">Choose</option>';

            for (var i in response) {
                skillLevelsList +=
                    '<option value="' +
                    i +
                    '">' +
                    response[i] +
                    "</option>";
            }
            jQuery("#skill-levels-"+rownum).html(skillLevelsList);
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function checkval(rownum){
    var skill = jQuery('#skill-select-'+rownum).val();
    var skill_level = jQuery('#skill-levels-'+rownum).val();
    jQuery.ajax({
        type: "POST",
        url: "/employee-skills/skill_level_check",
        data: {
            skill_id:skill,
            skill_level_id:skill_level,
        },
        dataType: "json",
        beforeSend: function(xhr) {
            xhr.setRequestHeader(
                "X-CSRF-Token",
                $('[name="_csrfToken"]').val()
            );
        },
        success: function(response) {
                $("#error-"+rownum).html("<span style='color:red;font-size:16px;'>Skill level was already added for this skill.Choose a different skill level.</span>");
                $("#skill-levels-"+rownum).val('');
        },
        error: function(err) {
            $("#error-"+rownum).html("");
        }
    });
}

setInterval(function(){
    $.ajax({
        type : "POST",
        url : "/employee-skills/notifications",
        success : function(response){
            //console.log(response);
            if(response==0 || !response){
                $(".skill-notification").hide();
            }
            else{
                $(".skill-notification").show();
                $(".skill-notification .badge").html('+' + response);
            }
        },
        error:function(err) {
            $(".skill-notification").hide();
            //console.log(err);
        }
    });
},5000);

$(document).ready(function(){
    $("#searcher").on("keypress click input", function () {
        var val = $(this).val();
        if(val.length) {
            $(".accordion .card.m-b-0 .collapsed").hide().filter(function () {
                return $('.card-block', this).text().toLowerCase().indexOf(val.toLowerCase()) > -1;
            }).show();
        }
        else {
            $(".accordion .card.m-b-0 .collapsed").show();
        }
    });
    //for test
    //$("#searcher").val('us').keyup();


    $('#employee-skill-approve').dataTable({
        "bStateSave": true,
        "bDestroy": true,
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        }
    });

  });

