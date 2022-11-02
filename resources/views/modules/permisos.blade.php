<x-app-layout>
     @section('title','Roles y Permisos')
     <link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
     @livewire('permisos-controller')
  </x-app-layout>

{{-- 
@section('styles')
	  <link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet" type="text/css" />
@endsection --}}


{{-- @section('content')

     @livewire('permisos-controller')

@endsection --}}