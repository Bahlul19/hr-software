$(document).ready(function() {
    $('.announcement-view').click(function(){
        var id= $(this).attr('data-id');
        console.log(id);
        $.post(
            '/Announcements/populateAnnouncement',
            {id:id},

            function(data) {
                $data = JSON.parse(data);
                $('#announcement-data').html($data.announcement);
                $('#announcement-modal').modal('show');
            },
        "json");
    });

});