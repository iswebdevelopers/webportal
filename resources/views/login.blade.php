@extends('layout.login')

@section('content')
<div class="row">
    @if(Session::has('status'))
    <div class="alert col-md-4 col-md-offset-4 {{Session::get('level')}}">
        {{ Session::get('status') }}
    </div>
    @endif

	@include('errors.error-list')
	
	<div class="panel panel-default col-md-4 col-md-offset-4">
		<div class="panel-heading">
			Login
		</div>
		<div class="panel-body">
			<form action="{{ action('AuthenticateController@login') }}" method="post">
			<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
	    		<div class="form-group">
	                <label>Email</label>
	                <input name="email" class="form-control" type="text" placeholder="john.smith@mail.com" required>
	            </div>
	    		<div class="form-group">
	                <label>Password</label>
	                <input name="password" class="form-control" type="password" placeholder="" required>
	            </div>
	            <button type="submit" class="btn btn-primary">Submit</button>
    		</form>
		</div>
    </div>		
</div>
@stop