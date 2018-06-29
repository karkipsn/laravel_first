<!DOCTYPE html>
<html>
<head>
	<title>Employees System</title>

	
    <link rel="stylesheet" ref="/bower/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <script src="/bower/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="/bower/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/bower/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/bower/bower_components/bootstrap-datepicker/js/jquery.min.js"></script>
    <script src="/bower/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css"></script>


    <!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker3.min.css"> -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    <scr``ipt src="/vendor/datatables/buttons.server-side.js"></script>
</head>
<body>


    <div class="container">
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if ($message = Session::get('Error'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    
     @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

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