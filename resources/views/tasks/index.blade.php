@extends('employees.layout')
@section('content')
<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-header">
      <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of employees</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('tasks.create') }}">Add new employee</a>
        </div>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      
      <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
              <thead>
                <tr role="row">
                 <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Id: activate to sort column ascending">Employee Id</th>
                 <th width="10%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Employee Name</th>
                 <th width="12%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Title</th>
                 <th width="12%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Birthdate: activate to sort column ascending">Description</th>
                 <th width="10%" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Picture: activate to sort column descending" aria-sort="ascending">Attachment</th>
                 <th width="12%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending">Deadline</th>
                 <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
               </tr>
             </thead>
             <tbody>
              @foreach ($tasks as $task)
              <tr role="row" class="odd">

                <td class="hidden-xs">{{ $task->employee_id }} </td>
                <td class="hidden-xs">{{ $task->employee_name }} </td>
                <td class="hidden-xs">{{ $task->title}}</td>
                <td class="hidden-xs">{{ $task->description }}</td>
               <td><img src="../{{$task->attachment }}" width="60px" height="60px"/></td>
                <td class="hidden-xs">{{ $task->deadline }}</td>
                
                <td>
                  <form class="row" method="POST" action="{{ route('tasks.destroy', ['id' => $task->id]) }}" onsubmit = "return confirm('Are you sure?')">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin">
                      Update
                    </a>
                    <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
            
          </tfoot>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-5">
        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($tasks)}} of {{count($tasks)}} entries</div>
      </div>
      <div class="col-sm-7">
        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
          {{ $tasks->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.box-body -->
</div>
</section>
<!-- /.content -->
</div>
@endsection