<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>Index Page For User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <!-- jQuery -->
  <script src="//code.jquery.com/jquery.js"></script>
  <!-- Scripts -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
  <script src="code.jquery.com/jquery-1.12.0.min.js"></script>
  <!-- DataTables -->
  <script src="//code.jquery.com/jquery-1.12.3.js"></script>
  <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script
  src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet"
  href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet"
  href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">

</head>
<body>

    
  <div class="container ">
    

    <div class="col-sm-4">
      <a class="btn btn-primary" href="{{ route('users.create') }}">Add new users</a>

      <br />
      @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
      @endif

       @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

            @if ($message = Session::get('error'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
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

          <tr >
            <td>{{$user->id}}</td>
            <td>{{$user->fname}}</td>
            <td>{{$user->lname}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->password}}</td>
            <td>{{$user->created_at}}</td>
            <td>{{$user->updated_at}}</td>
      

        <td>
         <form class="row" method="POST" action="{{ route('users.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('Are you sure?')">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">   Update </a>

          <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin"> Delete </button>

        </form>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>
</div>
</div>

<div class="row">
  <div class="col-sm-6" >
    <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($users)}} of {{count($users)}} entries</div></div>

    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
          {{ $users->links() }}
        </div>
      </div>
  </div>
  
  <!-- <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
   

</body>
</html>

