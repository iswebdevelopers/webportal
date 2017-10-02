@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Users List
        </h1>
    </div>
    @include('errors.error-list')
    <!-- search panel -->
    <div class="col-md-10 col-sm-12 col-xs-12">
        <div class="panel panel-default">
        <div class="panel-heading">
            User Search
        </div>
        <div class="panel-body">
            <form action="{{ action('UserController@search') }}" method="post" class="form-inline">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                <div class="form-group">
                    <label>Name</label>
                    <input name="name" class="form-control" type="text" value="{{(empty($input['name'])) ? '' : $input['name']}}" >
                </div>
                <div class="form-group">    
                    <label>Email Address</label>
                    <input name="email" class="form-control" type="email" value="{{(empty($input['email'])) ? '' : $input['email']}}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        </div>          
    </div>
    <!-- end search panel -->
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
            	<nav aria-label="Page navigation" class="pagination-nav">
            		@if(array_key_exists('current_page',$users))
				  		<h4>Page {{$users['current_page']}} of {{$users['last_page']}}</h4>
				  		<ul class="pagination">
					  		@if($users['current_page'] > 1)	
						    	<li>
						      		<a href="{{url()->current()}}/?page={{$users['current_page'] - 1}}" aria-label="Previous">
						        		<span aria-hidden="true">&laquo;</span>
						      		</a>
						    	</li>
					    	@endif
					    	@if($users['current_page'] < $users['last_page'])
						    	<li>
						      		<a href="{{url()->current()}}/?page={{$users['current_page'] + 1}}" aria-label="Next">
						        		<span aria-hidden="true">&raquo;</span>
						      		</a>
						    	</li>
					    	@endif
					  	</ul>
				  	@endif	
				</nav>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Supplier</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users['data'] as $_user)
                                <tr>
                                    <td>{{$_user['name']}}</td>
                                    <td>{{$_user['email']}}</td>
                                    <td>
                                        </td>
                                    <td><a id="recovery" data-fancybox data-type="ajax" data-src="/portal/user/recovery/{{$_user['id']}}" href="javascript:;">Recover Password</a></td>
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