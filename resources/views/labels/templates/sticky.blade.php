@if(!empty($data))
	@foreach ($data as $item)
		^XA
			^FX Top section.
			^CF0,40
			^FO60,50^FD{{$item['stockroomlocator']}}^FS

			^FX Second.
			^CF0,20
			^FO10,90^FDSize:{{$item['size']}}^FS
			^FO80,90^FDitem: {{$item['item']}}^FS

			^FX Third section with barcode.
			^BY1,100
			^FO50,130^BE^FD{{$item['barcode']}}^FS

			^FX Fourth section (the two boxes on the bottom).
			^CF0,20,
			^FO50,160^FD{{$item['description']}}^FS
			^CF0,20,
			^FO50,180^FD{{$item['colour']}}^FS
		^XZ
		<br/>
	@endforeach
@endif