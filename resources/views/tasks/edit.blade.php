@extends('employees.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update EmployeeTask</div>
                <div class="panel-body">

                   @if ($errors->any())
                   <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    {{ Form::hidden('type', 1) }}


                    <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Employee</label>
                        <div class="col-md-6">
                            <select class="form-control" name="employee_id">
                                @foreach ($employees as $employee)
                                <option value="{{$employee->emp_id}}">{{$employee->emp_id}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('employee_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('employee_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-4 control-label">Title</label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required>

                            @if ($errors->has('title'))
                            <span class="help-block">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description" class="col-md-4 control-label">Description
                        </label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" required>

                            @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                        <!-- <div class="form-group{{ $errors->has('attachment') ? ' has-error' : '' }}">
                            <label for="attachment" class="col-md-4 control-label">Attachment</label>

                            <div class="col-md-6">
                                <input id="attachment" type="file" class="form-control" name="attachment" value="{{ old('attachment') }}" required>

                                @if ($errors->has('attachment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('attachment') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label" >Attachment</label>
                            <div class="col-md-6">
                                <img src="../../{{$employee->attachment }}" width="50px" height="50px"/>
                                <input type="file" id="attachment" name="attachment" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">DeadLine Date</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text"  name="deadline" class="form-control pull-right" id="deadline" data-date-format="yyyy-mm-dd" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
