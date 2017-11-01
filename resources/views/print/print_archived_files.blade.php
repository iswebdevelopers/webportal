<div class="tab-pane fade in" id="archive">
<br/>
	@if(count($archives) > 0)
    	<table id="printfiles" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Order No.</th>
                    <th>Archived Date</th>
                    <th>Label Type</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
		    	@foreach($archives as $archive)
		    		<tr>
                        <td>{{$archive->order_id}}</td>
                        <td>{{$archive->updated_at}}</td>
                        <td>{{$archive->type}}</td>
                        <td>{{$archive->quantity}}</td>
                        <td>
                            <button type="button" class="btn btn-default" onclick="printZPL({{$archive->id}});">ZPL</button>
                        </td>
                    </tr>
		    	@endforeach
		    </tbody>
		</table>
	@else
	<h5 class="alert alert-info">There are no archived files.</h5>
	@endif		
</div>