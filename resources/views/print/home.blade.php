@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Print Shop
        </h1>
    </div>
    <div class="row-spread">
    	<div class="col-md-5">
            @include('print.connection_tab')
            
            @include('print.printer_tab')
        </div>
    </div>
    
    @include('print.rawprinting_tab') 
    @include('print.print_files') 
</div>
@stop