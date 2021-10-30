$('document').ready(function(){
  $(".datatable").DataTable({
    aaSorting: [[6, 'asc']],
    //bPaginate: false,
    //bFilter: false,
    //bInfo: false,
    //bSortable: true,
    //bRetrieve: true,
    aoColumnDefs: [
        { "aTargets": [ -1 ], "bSortable": false },
    ]
});
  $("#employee-utilize-compoff").change(function(event){
   var employee= $(this).val();
    $.ajax({
      url:'./get_employee_compoff/'+employee,
      type:'GET',
     success:function(data){
            if(data>=0)
            {
              $(remainingHours).html(data);
              $("input[name=date]").val(data);
            }else {
              alert("Compoff data not available for this user");
            }
     },
     error:function(error){
        console.log(error);
     }
    })
  })

  $("#addcontact").submit(function(e){
      var name =$("#name_of_contact").val();
      var number =$("#contact_no").val();
      var type =$("#type").val();
      var description =$("#description").val();
      var patt =/([+]{1}[0-9]{1,2}){0,1}[0-9]{10}$/  ///([+]?[0-9]{0,2}){0,1}[0-9]{10}$/     //([+]?\d{1,2}[.-\s]?)?(\d{3}[.-]?){2}\d{4}/g

    if(name.length>0 && number.length>0 && type.length>0){
      console.log(number.length)
      if(number.length>10)
      {
        if(patt.test(number))
          {// dont do anything let the from submit
          }else {
            alert("Entered Phone number is incorrect");
            return false;
          }
      }else{
        alert("Please provide a proper phone number");
        return false;
      }
    }else{
      alert("Plase provide all the fields");
      return false;
  }
})

var role=$("#selecetdrole").val();
var locations=$("#selecetdLocations").val();


if(role !==undefined && role!=null){
   var rolesarr=role.split(",");
    for(var i=0;i<rolesarr.length;i++){
      $("#roles option[value='"+rolesarr[i]+"']").attr("selected",'selected');
    }
}

if(locations !==undefined && locations!=null){
  var locationsarray=locations.split(",");
  for(var i=0;i<locationsarray.length;i++){
    $("#locations option[value='"+locationsarray[i]+"']").attr("selected",'selected');
  }
}

$('#locations').select2()
$('#roles').select2()
$('#feedback-for').select2()

/*$('select').selectize({
    sortField: 'text'
});*/

//Jquery for announcement module 

$(".announcementdatepicker").datepicker({
  "startDate": new Date(),
  "endDate": "+1y"
});


})
