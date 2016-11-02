@extends('person.index')

@section('add_person')
<div class="panel panel-default">
<div class="panel-body">
<h3>Editing Person "{{ $person->firstname }}"</h3>
<hr>

<!-- Display Validation Errors -->
@include('common.errors')
@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif

{!! Form::model($person, [
    'method' => 'PATCH',
    'route' => ['person.update', $person->id]
]) !!}

<div class="form-group">
    {!! Form::label('firstname', 'First Name:', ['class' => 'control-label']) !!}
    {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder'=>'e.g. John']) !!}
</div>
<div class="form-group">
    {!! Form::label('lastname', 'Last Name:', ['class' => 'control-label']) !!}
    {!! Form::text('lastname', null, ['class' => 'form-control','placeholder'=>'e.g. Doe']) !!}
</div>
<div class="form-group">
    {!! Form::label('age', 'Age (in years):', ['class' => 'control-label']) !!}
    {!! Form::text('age', null, ['class' => 'form-control','placeholder'=>'e.g 18']) !!}
</div>
<div class="form-group">
    {!! Form::label('phone_number', 'Phone Number:', ['class' => 'control-label']) !!}
    {!! Form::text('phone_number', null, ['class' => 'form-control','placeholder' => 'e.g. +254712345678','readonly' => 'readonly']) !!}
</div>
{!! Form::submit('Update Person', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

</div> 
</div>

@endsection