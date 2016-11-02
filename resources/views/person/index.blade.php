@extends('home')
@section('view_person')
<div class="panel-body">
<!-- Current Events -->

    <div class="panel panel-default">
        <div class="panel-heading">
            Current Persons
        </div>


        <div class="panel-body">
            @if (count($persons) > 0)
            <table class="table table-striped task-table">
                <thead>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Phone Number</th>
                    <th>Date Created</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($persons as $person)
                    <tr>
                        <td>{{ $person->firstname }}</td>
                        <td>{{ $person->lastname }}</td>
                        <td>{{ $person->age }}</td>
                        <td>{{ $person->phone_number }}</td>
                        <td>{{ $person->created_at }}</td>
                        
                        <td>
                            <a href="{{ route('person.show', $person->id) }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-eye"></i>
                            </button>
                            </a>
                        </td>
                        @if ($person->created_by === Auth::user()->id )
                        <td>
                            <a href="{{ route('person.edit', $person->id) }} ">
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-btn fa-edit"></i>
                            </button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ url('person/'.$person->id) }}" class="form-inline" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>
                                    </button>
                                </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>There are no persons created</p>
            @endif
        </div>
        </div>


</div>
@endsection

@section('add_person')
<div class="panel panel-default">
<!-- <div class="panel-heading">
    Add New Person
</div> -->
<div class="panel-body">
<h1>Add New Person</h1>
<hr>
<!-- Display Validation Errors -->
@include('common.errors')
@if(Session::has('create_message'))
<div class="alert alert-success">
    {{ Session::get('create_message') }}
</div>
@endif

{!! Form::open([
    'route' => 'person.store'
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

{!! Form::submit('Create New Person', ['class' => 'btn btn-primary']) !!}

{!! Form::close() !!}


</div> 
</div>
@endsection
