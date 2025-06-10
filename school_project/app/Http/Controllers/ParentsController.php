<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allParent()
    {
        return view('parent.parents');
    }

    public function parentDetails()
    {
        return view('parent.parentsdetails');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('parent.addparent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
        public function store(Request $request)
{
    // Validate incoming request
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|string',
        'blood_group' => 'required|string',
        'religion' => 'required|string',
        'email' => 'nullable|email',
        'address' => 'nullable|string',
        'phone' => 'nullable|string',
        'occupation' => 'nullable|string',
        'id_no' => 'nullable|string',
        'bio' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle file upload
    $photoPath = null;
    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // Insert data into database
    DB::table('parents')->insert([
        'first_name'   => $request->first_name,
        'last_name'    => $request->last_name,
        'gender'       => $request->gender,
        'blood_group'  => $request->blood_group,
        'religion'     => $request->religion,
        'email'        => $request->email,
        'address'      => $request->address,
        'phone'        => $request->phone,
        'occupation'   => $request->occupation,
        'id_no'        => $request->id_no,
        'bio'          => $request->bio,
        'photo'        => $photoPath,
        'created_at'   => now(),
        'updated_at'   => now(),
    ]);

    return redirect()->back()->with('success', 'Parent data inserted successfully.');
}

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
