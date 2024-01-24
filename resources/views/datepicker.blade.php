<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap DateTimePicker Example</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">

    <!-- Bootstrap DateTimePicker CSS -->
    <!-- Include the link for DateTimePicker CSS -->

    <!-- jQuery -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap DateTimePicker JS -->
    <!-- Include the link for DateTimePicker JS -->

    <!-- Optional: Add your own styles and scripts here -->

</head>

<body>
<div class="col-lg-3 margin-tb">
                    <label>From</label>
                    <div class="input-group date" id="fromdate" data-target-input="nearest">
                        <input type="text" name="doc_date_from" id="doc_date_from" class="form-control datetimepicker-input" autocomplete="off" required="required"/>
                        <div class="input-group-append" data-target="#fromdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-3 margin-tb">
                    <label>To</label>
                    <div class="input-group date" id="todate" data-target-input="nearest">
                        <input type="text" name="doc_date_to" id="doc_date_to" class="form-control datetimepicker-input" autocomplete="off" required="required"/>
                        <div class="input-group-append" data-target="#todate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div> 
                </div>

<!-- Your HTML content here -->

<!-- Initialize the datepicker -->
<script>
        
    $(document).ready(function(){
        // Assuming you have an input element with the ID 'datepicker'
        $('#datepicker').datepicker();
        // Add initialization for DateTimePicker if needed
        // $('#datetimepicker').datetimepicker();
        var today = new Date();
    var dd = String(today.getDate() + 1).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = dd + '/' + mm + '/' + yyyy;
    var dateFormat = "DD/MM/YYYY";
    
    
    $('#fromdate').datepicker({
	    maxDate: today,
        format: 'DD/MM/YYYY',
        useCurrent: false,
      
    });
    $('#todate').datepicker({
	    maxDate: today,
        format: 'dd/mm/yyyy',
        useCurrent: false,
        
    });
    });
</script>

</body>
</html>
