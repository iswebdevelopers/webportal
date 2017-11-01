@if(!empty($data))
	@foreach ($data as $carton)
		@foreach ($carton['carton_details'] as $details)
			^XA
				^FX Top section.
				^CF0,50
				^FO90,50^FDOrder No: {{$carton['order_number']}}^FS
				^FO90,120^FDStyle No: {{$carton['style']}}^FS
				^FO90,180^FDSize: {{$carton['item_size']}}^FS
				^FO90,250^FH^FDColour: {{str_replace('~',' _7e ',$carton['colour'])}}^FS
				^FO90,320^FDQty: {{$carton['quantity']}}^FS

				^FX Second.
				^CF0,30
				^FO50,400^FDItem No  {{$carton['item']}}^FS
				^FO50,450^FH^FDDescription   {{str_replace('~',' _7e ',$carton['description'])}}^FS

				^FX Third section with barcode.
				^BY3,2,230
				^FO30,550^BCN,150,N,N,Y
				^FD{{$details['barcode']}}^FS
				^FO30,720
				^A0N,50,40
				^FD{{$details['number']}}^FS

				^FX Fourth section (the two boxes on the bottom).
				^BY2,2,150
				^FO30,850^BCN,150,N,N,Y
				^FD{{$carton['product_indicator_barcode']}}^FS
				^FO30,1020
				^A0N,50,40
				^FD{{$carton['product_indicator_number']}}^FS
			^XZ
			<br/>
		@endforeach	
	@endforeach	
@endif