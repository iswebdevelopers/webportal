@extends('layout.app')

@section('content')
<div id="qz-alert" style="position: fixed; width: 60%; margin: 0 4% 0 26%; z-index: 900;"></div>
<div id="qz-pin" style="position: fixed; width: 30%; margin: 0 66% 0 4%; z-index: 900;"></div>

<div class="row">
    <div class="col-md-12">
        <h3 class="page-header">
            Print Shop
        </h3>
        <div class="row-spread">
        	<div class="col-md-5">
                @include('print.connection_tab')
                
                @include('print.printer_tab')
            </div>
        </div>
        <div class="col-md-6">
            <ul class="nav nav-pills">
                <li class="active"><a href="#print" data-toggle="tab">Pending</a></li>
                <li class=""><a href="#archive" data-toggle="tab">Archived</a></li>
            </ul>
            <div class="tab-content">
                
                @include('print.print_files')
                @include('print.print_archived_files')
            </div>
        </div>    
    </div>     
</div>
<script type="text/javascript" src="{{ asset('js/printer/main.js')}}"></script>
@stop