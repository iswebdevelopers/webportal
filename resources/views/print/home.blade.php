@extends('layout.app')

@section('content')
<div id="qz-alert" style="position: fixed; width: 60%; margin: 0 4% 0 36%; z-index: 900;"></div>
<div id="qz-pin" style="position: fixed; width: 30%; margin: 0 66% 0 4%; z-index: 900;"></div>

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