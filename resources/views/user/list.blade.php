@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Users List
        </h3>
    </div>
    @include('errors.error-list')
    @if(isset($users))
    <!--Order List-->                
    <div class="col-md-10 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="pull-right">
                    <a href="user/new"><button class="btn btn-primary btn-sm btn-side">New User</button></a>
                </span>
                Users 
            </div>
           <div class="panel-body">
                <div class="table-responsive">
                    <table id="users-list" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $_user)
                                <tr>
                                    <td>{{ $_user['role_id'] ? $_user['role_id'] : '' }}</td>
                                    <td>{{ucfirst($_user['name'])}}</td>
                                    <td>{{$_user['email']}}</td>
                                    <td>{{ucfirst($_user['role'])}}</td>
                                    <td><a data-vbtype="ajax" class="venbobox" href="/portal/user/recovery/{{$_user['id']}}" >Recover Password</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>              
    </div>
    <!--End Order List-->    	
    @endif  
</div>
@stop