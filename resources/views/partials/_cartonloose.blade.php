@if(!empty($data['cartonloose']))
	@foreach ($data['cartonloose'] as $cartonloose)
		@foreach ($cartonloose['carton'] as $carton)
				^XA
		^FX Top section.
		^CF0,70
		^FO90,50^FDOrder No: {{$cartonloose['ordernumber']}}^FS
		^FO90,120^FDStyle No: {{$cartonloose['style']}}^FS
		^FO90,180^FDSize: {{$cartonloose['size']}}^FS
		^FO90,250^FDColour: {{$cartonloose['colour']}}^FS
		^FO90,320^FDQty: {{$cartonloose['cartonquantity']}}^FS

		^FX Second.
		^CFA,30
		^FO50,400^FDItem No  {{$cartonloose['itemnumber']}}^FS
		^FO50,450^FDDescription   {{$cartonloose['description']}}^FS

		^FX Third section with barcode.
		^BY3.4,2,230
		^FO50,550^BC^FD{{$carton['number']}}^FS

		^FX Fourth section (the two boxes on the bottom).
		^BY2,2,230
		^FO50,850^BC^FD{{$cartonloose['productindicator']}} 1^FS
		^XZ
					<div class="first-row">
						<span class="title">
							<p>Order No  {{$cartonloose['ordernumber']}}</p>
							<p>Style No  {{$cartonloose['style']}}</p>
							<p>Size  {{$cartonloose['size']}}</p>
							<p>Colour  {{$cartonloose['colour']}}</p>
							<p>QTY  {{$cartonloose['cartonquantity']}}</p>
						</span>
					</div>
					<div class="second-row">	
						<p>Item No</p>
						<p>{{$cartonloose['itemnumber']}}</p>
						<p>Description</p>
						<p>{{$cartonloose['description']}}</p>
					</div>
					<div class="third-row">
						<div class="barcode">
							<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($cartonloose['productindicatorbarcode'], 'C128',1,50)}}" alt="barcode" /><br/>
							{{$cartonloose['productindicator']}}
						</div>
					</div>
					<div class="fourth-row">
						<div class="barcode">
							<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($carton['barcode'], 'C128',1,50)}}" alt="barcode" /><br/>
							{{$carton['number']}}
						</div>
					</div>
				</div>
		@endforeach	
	@endforeach
	</div>
@endif