$(function() {
    var completeUrl = window.location.href;
    $("#customid").val($("#formfield-id").val());
    var options = {
        onSave: function(evt, formData) {
            // Stop form from submitting normally
            event.preventDefault();
            var $form = document.getElementById("edit-fields-form");
            console.log($form);
            $form = new FormData($form);
            $form.append("field_data", formData);
            $.ajax({
                url: "/form-fields/edit/" + $form.get("id"),
                data: $form,
                cache: false,
                processData: false,
                contentType: false,
                type: "POST",
                success: function(data) {
                    if (data.includes("success")) {
                        let htmlData =
                            '<section class="content-header"> <div class = "alert alert-success alert-dismissible"><h4> <i class= "icon fa fa-check"> </i> Alert! </h4>The form has been saved. </div> </section> ';
                        $("#message").html(htmlData);
                        $("#form-create-success").modal("show");
                    } else {
                        let htmlData =
                            '<section class="content-header"> <div class = "alert alert-error alert-dismissible"><h4> <i class= "icon fa fa-check"> </i> Alert! </h4>The form could not be saved. </div> </section> ';
                            $("#message").html(htmlData);
                            $("#form-create-success").modal("show");
                    }
                }
            });
        },
        disabledAttrs: ["access"],
        controlOrder: [
            "header",
            "text",
            "textarea",
            "number",
            "select",
            "radio-group",
            "file",
            "checkbox-group",
            "date",
            "autocomplete"
        ],
        typeUserAttrs: {
            autocomplete: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            "checkbox-group": {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            file: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            "radio-group": {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            select: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            number: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            textarea: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            header: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            date: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            },
            text: {
                dependent: {
                    label: "Field dependent",
                    options: {
                        "0": "select"
                    }
                },
                dependentValue: {
                    label: "Dependent Value",
                    description:
                        "Enter dependent value, if value is true field will show"
                }
            }
        },
        typeUserEvents: {
            text: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            "radio-group": {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            "checkbox-group": {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            textarea: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            number: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            select: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            file: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            header: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            date: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            },
            autocomplete: {
                onadd: function(fld) {
                    fld.querySelector(".fld-dependent").onclick = function(e) {
                        var x = document.getElementsByClassName("fld-dependent");
                        var option = document.createElement("option");
                        var allInput = document.querySelectorAll(
                            "#build-wrap ul li .prev-holder input" +
                                ",#build-wrap ul li .prev-holder select"
                        );

                        allInput.forEach(function(item) {
                            var exists = false;
                            for (i = 0; i < e.target.length; ++i) {
                                if (e.target.options[i].text == item.name) {
                                    exists = true;
                                    break;
                                } else {
                                    exists = false;
                                }
                            }
                            if (exists == true) {
                                //
                            } else {
                                option = document.createElement("option");
                                option.text = item.name;
                                option.value = item.name;
                                e.target.add(option);
                            }
                        });
                    };
                }
            }
        }
    };

    if ($("#edit-fields-form").length > 0){
        var fbEditor = document.getElementById("build-wrap");
        var dataTable = document.getElementById("tableData");
        var formData = dataTable.value;
        var formBuilder = $(fbEditor).formBuilder(options);
        document.getElementById("setData").addEventListener("click", function() {
            console.log("here");
            event.preventDefault();
            formBuilder.actions.setData(formData);
        });

        /*$(window).on('load', function() {console.log('loaded');$('#setData').click();//formBuilder.actions.setData(formData);})*/
        $(".close").on("click", function() {
            location.reload(true);
        });
    }




    if ($("#form-view").length > 0) {
          console.log("here in this section");
        var fbTemplate = document.getElementById('build-wrap');
        var dataTable = document.getElementById("tableData");
        var formData = dataTable.value;
        var formRenderInstance = $('#build-wrap').formRender({
            dataType: 'json',
            formData: formData
        });

        $( "#form-view button:last" ).click(function() { 
            if($("#form-view")[0].checkValidity()) {
           
                var empid=$("#feedback-for").val();
                if(empid==0){
                  alert("Please select a employee"); 
                  return false;
                }
                $("#submitted_data").val(JSON.stringify(formRenderInstance.userData));
                var $form = document.getElementById("form-view");
                    $form = new FormData($form);  
                    $(this).attr('disabled',true);
                    $("#form-loader").modal('show');    
                $.ajax({
                    url: "/form-submissions/add",
                    data: $form,
                    cache: false,
                    processData: false,
                    contentType: false,
                    type: "POST",
                    success: function(data) {
                        $("#form-loader").modal('hide');
                        if (data.includes("success")) {
                            let htmlData =
                                '<section class="content-header"> <div class = "alert alert-success alert-dismissible"><h4> <i class= "icon fa fa-check"> </i> Alert! </h4>The form has been submitted. </div> </section> ';
                            $("#message").html(htmlData);
                            $("#form-submission-success").modal("show");
                        } else {
                            let htmlData =
                                '<section class="content-header"> <div class = "alert alert-error alert-dismissible"><h4> <i class= "icon fa fa-check"> </i> Alert! </h4>The form could not be saved. </div> </section> ';
                                $("#message").html(htmlData);
                                $("#form-submission-success").modal("show");
                        }
                    }
                });
            } else {
                console.log("html5 invalidated ");
                alert('Please fill mandatory fields!');
                return false;
            }
            window.location.href = '#';
        });
    }

    if ($("#admin_view_submitted_data").length > 0){

        var fbTemplate = document.getElementById('build-wrap');
        var dataTable = document.getElementById("tableData");
        var formData = dataTable.value;
        var formRenderInstance = $('#build-wrap').formRender({
                dataType: 'json',
                formData: formData
            });
    }

    let slug = function(str) {
        let $slug = '';
        let trimmed = jQuery.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
        replace(/-+/g, '-').
        replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    };
    $('.forms #title').keyup(function(){
      $('.forms #slug').val(slug($(this).val()));
    });
});

var selected;
$(document).on('click','.option-actions',function(){
    selected = this;
    $("#overlay").show();
    $("#overlay").focus();
});

function done()
{
    var parentId= $(selected).parent();
    var selector = $("#selector").val();
    var name = parentId.find("ol").find("li").find("input").attr("name");
    var splittedName = name.split("-")[1]

    if( selector != 'blank'){
        var $form = document.getElementById("edit-fields-form");
                    $form = new FormData($form);
        $.ajax({
            url: "/form-fields/fetchOptions/"+selector+"/"+splittedName, 
            success: function(result){
                parentId.find("ol").html(result);
            }
        });
    }
    $("#overlay").hide();
}

function cancel()
{
    $("#overlay").hide();
}

$(document).ready(function(){
    if(window.location.href.includes("form-submissions/view")){
        $("#admin_view_submitted_data :input").prop("disabled", true);
        $("#admin_view_submitted_data :button").hide();
    }
    if(window.location.href.includes("/adminview/")){
        $("#build-wrap :button").prop("disabled", true);
    }
    if(window.location.href.includes("/pages/submitFormMain")){
        $("#build-wrap :button").prop("disabled", true);
    }
});

