@extends('layout.popup')
@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Account Edit - {{ucfirst($users['name'])}}
        </h3>
    </div>    
    <!--account settings-->
    <div class="col-md-10 col-sm-12 col-xs-12">
   <!--  @if ( $errors->count() > 0 )
                <div class="alert alert-danger col-md-4 col-md-offset-4">
                    <ul>
                        @foreach( $errors->all() as $message )
                          <li>{{ $message }}</li>
                        @endforeach
                      </ul> 
                </div>
            @endif -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Account Settings
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <form action="{{action('UserController@recovery')}}" method="post" id="recovery-form">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <input name="token" type="hidden" id="token" value="{{$token}}" />
                        <div class="form-group">
                            <label>User Email</label>
                            <input class="form-control" name="email" type="email" value="{{$users['email']}}" placeholder="john.smith@mail.com" required>
                        </div>

                        <!-- <div class="form-group">
                            <label>New Password</label>
                            <input class="form-control" name="password" type="password" placeholder="">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input class="form-control" name="password_confirmation" type="password" placeholder="">
                        </div> -->
                        <button type="submit" id="recovery-submit" class="btn btn-primary">Recover Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end account settings-->
</div>
<script type="text/javascript">
    $('#recovery-form').bind("submit",function(e) {
        e.preventDefault();
        var token = $('#token').val();
        $.ajax({
            method: "POST",
            url: "/portal/user/recovery?token=" + token,
            data: $(this).serializeArray(),
        success: function( data ) {
            if(data.status == 'success'){
              var html = "<div class='alert alert-success'><ul>";  
            } else {
              var html = "<div class='alert alert-danger'><ul>";
            }

            html = html + "<li>" +  data.result.data.message + "</li></ul></div>" ;

            $(".vbox-content div #page-inner .row .col-md-10").prepend(html);
          },
          error: function() { 
            alert("Something has gone wrong. Please try again."); 
          }
        });
    });
</script>
@stop