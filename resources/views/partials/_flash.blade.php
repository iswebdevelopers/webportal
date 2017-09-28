@if(Session::has('message'))
<p class="alert {{ Session::get('class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif