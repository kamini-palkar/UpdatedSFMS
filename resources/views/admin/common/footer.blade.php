<script>
var hostUrl = "assets/";
</script>

<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{url('assets/js/scripts.bundle.js')}}"></script>
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#prospect-master').DataTable({
        "searching": true
    });

});
</script>



</body>