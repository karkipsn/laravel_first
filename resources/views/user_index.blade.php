<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index Page For User</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
      <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
    <table id="toop" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Created</th>
        <th>Updated</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($users as $user)
    
      <tr>
        <td>{{$user['id']}}</td>
        <td>{{$user['fname']}}</td>
        <td>{{$user['lname']}}</td>
        <td>{{$user['email']}}</td>
        <td>{{$user['password']}}</td>
        <td>{{$user['created_at']}}</td>
        <td>{{$user['updated_at']}}</td>
        <td><a href="{{action('HomeController@edit', $user['id'])}}" class="btn btn-warning">Edit</a></td>
        <td>
        
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>

  </body>
</html>