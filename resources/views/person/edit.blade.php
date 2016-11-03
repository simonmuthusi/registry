@extends('person.index')

@section('add_person')
<div class="panel panel-default">
<div class="panel-body">
    <div class="minor-color pull-right">
          <span class="input-group-btn">
          <span class="input-group-btn">
            <a href="{{ route('person.index', $person->id) }}">
              <button type="button" class="btn btn-default btn-number minor-color" title="Add New" data-type="plus" data-field="quant[1]">
                  <span class="glyphicon glyphicon-plus"></span>
              </button>
          </a>
          </span>
    </div>
<h3>Editing Person "{{ $person->firstname }}"</h3>

<hr>

<!-- Display Validation Errors -->
@include('common.errors')
@if(Session::has('update_message'))
    <div class="alert alert-success">
        {{ Session::get('update_message') }}
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
    {!! Form::text('phone_number', null, ['class' => 'form-control','placeholder' => 'e.g. +254712345678']) !!}
</div>
{!! Form::submit('Update Person', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}

</div> 
</div>

@endsection