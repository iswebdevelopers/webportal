@if(!empty($data))
	@foreach ($data['carton'] as $carton)
		@foreach ($carton['carton_details'] as $details)
			^XA

			^FX Top section.
			^CF0,50
			^FO90,50^FDOrder No: {{$data['order_number']}}^FS
			^FO90,110^FDStyle No:{{$data['style']}}^FS
			^FO90,170^FDPack Item:{{$data['packnumber']}}^FS
			^CF0,300
			^FO580,30^FD{{$data['packtype']}}^FS

			^FX Second.
			^CF0,40
			^FO50,300^FH^FDDescription   {{$data['description']}}^FS
			^FO50,340^FDGroup  {{$data['group']}}^FS
			^FO50,380^FDDept  {{$data['dept']}}^FS
			^FO50,420^FDClass  {{$data['class']}}^FS
			^FO50,460^FDSubClass  {{$data['subclass']}}^FS

			^FX Third section with barcode.
			^BY3,2,230
			^FO50,550
			^BCN,150,N,N,Y
			^FD{{$carton['barcode']}}^FS
			^FO50,720
			^A0N,50,40
			^FD{{$carton['number']}}^FS

			^FX Fourth section (the two boxes on the bottom).
			^BY2,2,150
			^FO50,850
			^BCN,150,N,N,Y
			^FD{{$data['product_indicator_barcode']}}^FS
			^FO50,1020
			^A0N,50,40
			^FD{{$data['product_indicator_number']}}^FS
			^XZ
			<br/>
		@foreach	
	@endforeach	
@endif