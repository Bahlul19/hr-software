$('document').ready(function(){
    $("#searchAttendence").on('submit',function(e){
        // e.preventDefault();
       
        var officeLctn= $("#office_lctn").val();
        var emploees= $("#emploees").val();
        var from_date=$("#from-date").val();
        var to_date=$("#to-date").val();
        var fromDateArray=from_date.split("-");
        var toDateArray=to_date.split("-");
        if( (officeLctn===undefined && emploees===undefined ) || (officeLctn!=="" && emploees!==null) || (toDateArray.length >1  && fromDateArray.length>1))
        {
            if(toDateArray.length >1 && fromDateArray.length>1)
            {
                // console.log("testing sjconnect ");
              if(fromDateArray[0] <= toDateArray[0]){
                  if(fromDateArray[1]<=toDateArray[1]){
                      if(fromDateArray[2]<=toDateArray[2]){
                        //   $("#searchAttendence").submit(); 
                        return true;
                      }else {
                          alert("selected date is incorrect. please check the days ");
                          return false;
                      }     
                  }else {
                      alert("selected date is incorrect. please check the months");  
                      return false;
                  }  
              }else {
                  alert("selected date is incorrect. please check the years");  
                  return false;    
              }
            }else {
                if((officeLctn!==undefined && emploees!==undefined ) || (officeLctn!=="" && emploees!==null)){
                    return true;
                }else{
                    alert("Plase select dates"); 
                    return false;
                }
            } 
        }else {
            alert("Please select office loaction or employee");
            return false;
        }

       
    })
})