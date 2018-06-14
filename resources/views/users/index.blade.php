<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index Page For User</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
      <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>
        <!-- DataTables -->
        <!-- Bootstrap JavaScript -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


    <!-- Scripts -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.11/js/dataTables.bootstrap.min.js"></script>
  </head>
  <body>

      <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('tasks.create') }}">Add new employee</a>
        
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
    <table id="toop" class="table table-bordered table-hover dataTable" role="grid">
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

        <td>
          <a href="{{action('HomeController@edit', $user['id'])}}" class="btn btn-warning">Edit</a>
          <a href="{{action('HomeController@destroy', $user['id'])}}" class="btn btn-warning">Delete</a>
        </td>
       
        
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  <div class="row">
      <div class="col-sm-5">
        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($users)}} of {{count($users)}} entries</div>
      </div>
      
    </div>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
$(document).ready(function() {
    $('#toop').DataTable();
    
} );
</script>

  </body>
</html>