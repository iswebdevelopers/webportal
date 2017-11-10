@extends('layout.login')

@section('content')

<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <h3 class="page-header">
            Password Reset
        </h3>
    </div>    
    @if ( $errors->count() > 0 )
        <div class="alert col-md-4 col-md-offset-4 alert-danger">
            <ul>
                @foreach( $errors->all() as $message )
                  <li>{{ $message }}</li>
                @endforeach
              </ul> 
        </div>
    @endif
    @if (!empty($data['message']))
         <div class="alert col-md-4 col-md-offset-4 alert-{{$data['status']}}">
             {{$data['message']}}
         </div>
    @endif
    <!--account settings-->
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Account Settings
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <form action="" method="post">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input name="token" type="hidden" value="{{$token ? $token : ''}}">
                        <div class="form-group">
                            <label>UserName</label>
                            <input class="form-control" name="email" type="email" value="{{empty($input['email']) ? '' : $input['email']}}" placeholder="john.smith@mail.com">
                        </div>
                       <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" name="password" type="password" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input class="form-control" name="password_confirmation" type="password" placeholder="">
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end account settings-->
</div>
@stop    