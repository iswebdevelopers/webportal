<div class="row">
    <div class="col-md-6">
    	@if(count($prints) > 0)
	    	<table id="printfiles" class="table table-striped table-bordered table-hover">
	            <thead>
	                <tr>
	                    <th>Order No.</th>
	                    <th>Label Type</th>
	                    <th>Quantity</th>
	                    <th>Action</th>
	                </tr>
	            </thead>
	            <tbody>
			    	@foreach($prints as $print)
			    		<tr>
	                        <td>{{$print->order_id}}</td>
	                        <td>{{$print->type}}</td>
	                        <td>{{$print->quantity}}</td>
	                        <td>
	                            <button type="button" class="btn btn-default" onclick="printZPL({{$print->id}});">ZPL</button>
	                        </td>
	                    </tr>
			    	@endforeach
			    </tbody>
			</table>
		@else
		<p class="alert alert-info">There are no files to print.</p>
		@endif	
    </div>
</div> 	