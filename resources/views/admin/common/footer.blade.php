<script>
var hostUrl = "assets/";
</script>

<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{url('assets/js/scripts.bundle.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="{{url('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{url('assets/js/widgets.bundle.js')}}"></script>
<script src="{{url('assets/js/custom/widgets.js')}}"></script>
<script src="{{url('assets/js/custom/apps/chat/chat.js')}}"></script>
<script src="{{url('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{url('assets/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{url('assets/js/custom/utilities/modals/new-target.js')}}"></script>
<script src="{{url('assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

  <!-- For JSTREE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#prospect-master').DataTable({
        "searching": false,
		"lengthChange": false,
		"paging": false,
    });

    // $.ajax({
	// 		type: 'get',
	// 		url: '/get-permissions',
	// 		success: function (response) {
	// 			console.log(response);

	// 		},
	// 		error: function (error) {
	// 			console.error( error);
	// 		}
	// 	});
	

});
	setTimeout(function() {
            $("div.alert-success").slideUp(300, function() {
                $(this).remove();
            });
        }, 2000);

	$('.diplsidebarsubmenu').on('click', function (event) {
		// alert(1);
		var $parent = $(this).closest('.menu-item');
		var menuItemId = $(this).data('menu-item-id');
		var url=$(this).data('url');
        console.log(menuItemId);
		$.ajax({
			type: 'POST',
			url: '/store-selected-menu-item-id',
			data: {
				menuItemId: menuItemId,
				_token: '{{ csrf_token() }}'
			},
			success: function (response) {
				console.log(response);
				      // Redirect to the desired URL
					  window.location.href = url;

			},
			error: function (error) {
				console.error('Error storing selected menu item ID', error);
			}
		});
	});

	$('#changepassword').on('click', function (event) {
		event.preventDefault();
		var newPassword=$('#newPassword').val();
		var confirmPassword=$('#confirmPassword').val();
	
		if(newPassword==confirmPassword){
			$.ajax({
			type: 'POST',
			url: '/change-password',
			data: {
				newPassword: newPassword,
				confirmPassword:confirmPassword,
				_token: '{{ csrf_token() }}'
			},
			success: function (response) {
				console.log(response);
				if(response=="changed"){
					toastr.success('Password created successfully!', 'Success');
					// $('#changePasswordModal').modal('toggle');
		$('#changePasswordModal').modal('hide');

				}
				else{
					toastr.error('Error sending email', 'Error');
				}
			},
			error: function (error) {
				console.error('Error in password change', error);
				toastr.error('Error sending email', 'Error');
			}
		});
			
		}
		else{
			alert("Please enter same password and confirm password");
		}

	});

</script>



</body>