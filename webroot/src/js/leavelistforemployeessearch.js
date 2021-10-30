$('document').ready(function(){

	$('#search').keyup(function(){
		var searchKey = $(this).val();
		//console.log(searchKey);
		searchEmployeesLeave ( searchKey );
	});

	function searchEmployeesLeave( keyword )
	{
		var data = keyword;
		$.ajax({
			method : 'get',
			url : "<?php echo $this->Url->build( ['controller' => 'EmpLeaves','action' => 'index' ] ); ?>",
			data : {keyword : data},

			succcess: function ( html )
			{
				$('leave-request').html(html);
			}
		});
	}

	});
