$(document).ready(function(){$(".announcement-view").click(function(){var n=$(this).attr("data-id");console.log(n),$.post("/Announcements/populateAnnouncement",{id:n},function(n){$data=JSON.parse(n),$("#announcement-data").html($data.announcement),$("#announcement-modal").modal("show")},"json")})});