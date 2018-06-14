

<!DOCTYPE html>
<html>
 <head>
    <meta charset="utf-8">
    <title>User Management System </title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">  
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>  
  </head>
<body>
	 <div class="container">
	 	 <h2>User Management System</h2><br/>
	<form method="post"  action="{{ route('users.store') }}">   
    @csrf
		
			 <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Name">First Name:</label>
            <input type="text" class="form-control" name="fname">
          </div>
      </div>

           <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Name">Last Name:</label>
            <input type="text" class="form-control" name="lname">
          </div>
      </div>

		<div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="Email">Email:</label>
              <input type="text" class="form-control" name="email">
            </div>
          </div>

         
		
		<div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="Password">Password:</label>
              <input type="password" class="form-control" name="password">
            </div>
          </div>


          <div class="row">
          <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="Password">Confirm Password:</label>
              <input type="password" class="form-control" name="confirm_password">
            </div>
          </div>

		<div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success">Register</button>
          </div>
        </div>    
	    
	</form>
</body>
</html>


