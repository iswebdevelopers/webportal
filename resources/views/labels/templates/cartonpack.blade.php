@if(!empty($data))
	@foreach ($data['carton'] as $carton)
		@foreach ($carton['carton_details'] as $details)
			^XA

			^FX Top section.
			^CF0,70
			^FO90,50^FDOrder No: {{$data['order_number']}}^FS
			^FO90,110^FDStyle No:{{$data['style']}}^FS
			^FO90,170^FDPack Item:{{$data['packnumber']}}^FS
			^CF0,340
			^FO580,30^FD{{$data['packtype']}}^FS

			^FX Second.
			^CFA,30
			^FO50,300^FDDescription   {{$data['description']}}^FS
			^FO50,340^FDGroup  {{$data['group']}}^FS
			^FO50,380^FDDept  {{$data['dept']}}^FS
			^FO50,420^FDClass  {{$data['class']}}^FS
			^FO50,460^FDClass  {{$data['subclass']}}^FS

			^FX Third section with barcode.
			^BY3.4,2,230
			^FO50,550^BC^FD{{$carton['number']}}^FS

			^FX Fourth section (the two boxes on the bottom).
			^BY2,2,230
			^FO50,850^BC^FD{{$data['product_indicator_number']}}^FS
			^XZ
			<br/>
		@foreach	
	@endforeach	
@endif