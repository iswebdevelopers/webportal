@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Order List
        </h3>
    </div>
    <!--Order List-->                
    @include('partials._list')
    <!--End Order List-->  
</div>
@stop