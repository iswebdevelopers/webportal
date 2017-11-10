@if(!empty($data))
	@foreach ($data as $item)
		^XA
			^FX Top section.
			^CF0,60
			^FO30,30^FD{{$item['stockroomlocator']}}^FS

			^FX Second.
			^CF0,30
			^FO10,90^FDSize:{{$item['size']}}^FS
			^FO80,90^FDitem: {{$item['item']}}^FS

			^FX Third section with barcode.
			^BY2,2,50
			^FO30,140^BE^FD{{$item['barcode']}}^FS

			^FX Fourth section (the two boxes on the bottom).
			^CF0,30,
			^FO50,220^FH^FD{{str_replace('~','_7e',$item['description'])}}^FS
			^CF0,30,
			^FO50,250^FH^FD{{str_replace('~','_7e',$item['colour'])}}^FS
		^XZ
		<br/>
	@endforeach
@endif