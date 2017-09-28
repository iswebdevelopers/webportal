@if(!empty($data))
	@foreach ($data as $carton)
		@foreach ($carton['carton_details'] as $details)
			^XA
				^FX Top section.
				^CF0,70
				^FO90,50^FDOrder No: {{$carton['order_number']}}^FS
				^FO90,120^FDStyle No: {{$carton['style']}}^FS
				^FO90,180^FDSize: {{$carton['item_size']}}^FS
				^FO90,250^FDColour: {{$carton['colour']}}^FS
				^FO90,320^FDQty: {{$carton['quantity']}}^FS

				^FX Second.
				^CFA,30
				^FO50,400^FDItem No  {{$carton['item']}}^FS
				^FO50,450^FDDescription   {{$carton['description']}}^FS

				^FX Third section with barcode.
				^BY3.4,2,230
				^FO50,550^BC^FD{{$details['number']}}^FS

				^FX Fourth section (the two boxes on the bottom).
				^BY2,2,230
				^FO50,850^BC^FD{{$carton['product_indicator_number']}} 1^FS
			^XZ
			<br/>
		@endforeach	
	@endforeach	
@endif