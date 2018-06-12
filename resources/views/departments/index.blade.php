@extends('departments.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Departments</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('departments.create') }}"> Create New Departmrnt</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($departments as $department)
        <tr>
            <!-- <td>{{ ++$i }}</td> -->
            <td>{{ $department->id }}</td>
            <td>{{ $department->name }}</td>
            <td>
                <form action="{{ route('departments.destroy',$department->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('departments.show',$department->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('departments.edit',$department->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')

   
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $departments->links() !!}


@endsection