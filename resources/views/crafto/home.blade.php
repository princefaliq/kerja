@extends('crafto.master')
@section('title','Beranda')
@section('content')
    @include('crafto.inc.baner')
    @include('crafto.inc.keuntungan')
    @include('crafto.inc.about')
{{--    @include('crafto.inc.lowongan')--}}
    {{--@include('crafto.inc.patner')--}}
    @include('crafto.inc.flayer')
    @include('crafto.inc.jadwal')
    {{--@include('crafto.inc.artikel')--}}
    @include('crafto.inc.logo_patner')
    @include('crafto.inc.countdown')
    @include('crafto.inc.testimoni')
    {{--@include('crafto.inc.modal')--}}
@endsection

