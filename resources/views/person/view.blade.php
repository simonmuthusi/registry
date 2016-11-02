@extends('person.index')

@section('add_person')
<div class="panel panel-default">
<div class="panel-body">
    <div class="panel panel-default">
        <div class="panel-heading">
            Person Details
        </div>
        <div class="panel-body">
           <div class="form-inline">
                <label>First Name</label>
                <div>{{ $person->firstname }}</div>
            </div>
            <div class="form-inline">
                <label>Last Name</label>
                <div>{{ $person->lastname }}</div>
            </div>
            <div class="form-inline">
                <label>Age </label>
                <div>{{ $person->age }} years</div>
            </div>
            <div class="form-inline">
                <label>Phone Number</label>
                <div>{{ $person->phone_number }}</div>
            </div>
            @if (Auth::check())
            @if ($person->created_by === Auth::user()->id )
            <div class="form-inline">
                <label>Is Active</label>
                <div>{{ $is_active }}</div>
            </div>
            @endif
            @endif
        </div>
        </div>

</div>
</div>

@endsection

