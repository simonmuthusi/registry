<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Person;
use App\User;
use Auth;
use Carbon\Carbon;
use Session;
use Mail;
use SMSProvider;
use Config;

class PersonController extends Controller {
    private $STATUS = ['no','yes'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $persons = Person::orderBy('created_at', 'asc')
        ->where('is_active',true)
        ->get();

        return view('person.index', [
            'persons' => $persons
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('person.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'age' => 'required|numeric|min:18|max:200',
            'phone_number' => 'required|phone:US,BE,KE|unique:people',
        ]);

        $person = Person::create(array(
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "age" => $request->age,
            "phone_number" => $request->phone_number,
            "created_by" => Auth::user()->id
            ));

        $person->created_by = Auth::user()->id;
        $person->save();

        Session::flash('create_message', 'Person successfully created');

        // send sms
        $sms_message = "Hi ".$request->firstname.",\nYou have been created on ".Config::get('app.name')."\n Details: ".$request->firstname." ".$request->lastname.", ".$request->age." years, ".$request->phone_number."\nRegistry Team";

        SMSProvider::sendMessage($request->phone_number, $sms_message);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $person = Person::findOrFail($id);
        $persons = Person::orderBy('created_at', 'asc')
        ->where('is_active',true)
        ->get();
        $is_active = $this->STATUS[$person->is_active];

        return view('person.view', [
            'person' => $person,
            'persons' => $persons,
            'is_active' => $is_active,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $person = Person::findOrFail($id);
        $persons = Person::orderBy('created_at', 'asc')
        ->where('is_active',true)
        ->get();

        return view('person.edit', [
            'person' => $person,
            'persons' => $persons,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $person = Person::findOrFail($id);

        $input = $request->all();

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'age' => 'required|numeric|min:18|max:200',
        ]);
        // if phone number is different validate it 
        if($person->phone_number != $request->phone_number)
        {
            $this->validate($request, [
            'phone_number' => 'required|phone:US,BE,KE|unique:people',
        ]);
        }
        
        

        $person->fill(array(
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "age" => $request->age,
            "phone_number" => $request->phone_number,
            ))->save();

        Session::flash('update_message', 'Person successfully updated');

        // $sms_message = "Hi ".$request->firstname.",\nYour details on ".Config::get('app.name')."\n have been updated. Details: ".$request->firstname." ".$request->lastname.", ".$request->age." years, ".$request->phone_number."\nRegistry Team";

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}

