<!DOCTYPE html>
<html>
<head>
	<title>Employees System</title>
	<script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker3.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<scr``ipt src="/vendor/datatables/buttons.server-side.js"></script>
</head>
<body>


<div class="container">
    @yield('content')
</div>


<script type="text/javascript">  
	$(document).ready(function() {

         $('#example2').DataTable({
        dom: 'Bfrtip',
    buttons: [
        'excel', 'csv', 'copy','print', 'pdf'
    ],
       });

        $('#birthdate').datepicker({ 
            autoclose: true, 
            locale: 'no',  
        

         }); 
    //      $("#birthdate").on("change", function () {
    //     var fromdate = $(this).val();
    //     alert(fromdate);
    // });
         $('#hireddate').datepicker({ 
            autoclose: true,   
           
         }); 
         $('#deadline').datepicker({ 
            autoclose: true,   
           
         }); 
         
         }); 
    </script>

</body>
</html>