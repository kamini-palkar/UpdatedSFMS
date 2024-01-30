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
<script>
$(document).ready(function() {
    var table = $('#prospect-master').DataTable({
        "searching": false,
		"lengthChange": false,
		"paging": false,
    });

});
	setTimeout(function() {
            $("div.alert-success").slideUp(300, function() {
                $(this).remove();
            });
        }, 2000);

	$('.menu-link').on('click', function (event) {
		var $parent = $(this).closest('.menu-item');
		var menuItemId = $(this).data('menu-item-id');

		$.ajax({
			type: 'POST',
			url: '/store-selected-menu-item-id',
			data: {
				menuItemId: menuItemId,
				_token: '{{ csrf_token() }}'
			},
			success: function (response) {
				console.log('Selected menu item ID stored successfully');

			},
			error: function (error) {
				console.error('Error storing selected menu item ID', error);
			}
		});
	});


</script>



</body>