<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ParentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allParent()
    {
        $parents_array = DB::table('parents')->get();
        return view('parent.allparent', compact('parents_array'));
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
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'parent_occupation' => 'required|string',
            'spouse_name' => 'required|string|max:255',
            'spouse_occupation' => 'required|string',
            'id_no' => 'nullable|string',
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        // Insert data into database
        DB::table('parents')->insert([
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'parent_occupation' => $request->parent_occupation,
            'spouse_name' => $request->spouse_name,
            'spouse_occupation' => $request->spouse_occupation,
            'id_no' => $request->id_no,
            'blood_group' => $request->blood_group,
            'religion' => $request->religion,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'photo' => $photoPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Parent data inserted successfully.');

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

    public function viewParent($id)
    {
        $getParentByID = DB::table('parents')->where('id', $id)->first();
        // print_r($getStudentByID);
        return view('parent.viewParent', compact('getParentByID'));

    }

    public function deleteParent($id)
    {

        DB::table('parents')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Parent deleted successfully.');
    }

    public function editParent($id)
    {
        $getParentByID = DB::table('parents')->where('id', $id)->first();
        //print_r($getStudentByID);
        return view('parent.editParent', compact('getParentByID'));

    }

    public function updateParent(Request $request)
    {
        // Validate input\
        //echo "line 185 updateStudent Method  / Function";
        $mydata = $request->all();

        //print_r( $mydata);

        //update query for $mydata
        DB::table('parents')
            ->where('id', $request->id)
            ->update([
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'parent_occupation' => $request->parent_occupation,
                'spouse_name' => $request->spouse_name,
                'spouse_occupation' => $request->spouse_occupation,
                'id_no' => $request->id_no,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,

            ]);

        return redirect()->route('allparent')->with('success', 'Parent data updated successfully.');


    }
}
