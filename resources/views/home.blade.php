@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div id="left-panel" class="col-md-8 col-md-offset-0">
                @yield('view_person')
        </div>

        <div id="right-panel" class="col-md-4 col-md-offset-0">
        @yield('add_person')
        @yield('edit_person')
        </div>

    </div>
</div>
@endsection

@section('user_menus')
@if (Auth::guest())
@else
    <li><a href="{{ url('/person/all') }}">View All</a></li>
@endif

@endsection
