@extends('layout.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Printed Label History
        </h1>
    </div>
   @include('errors.error-list')
    <!--label history-->                
    @include('partials._history')
    <!--End label history-->
</div>
@stop    