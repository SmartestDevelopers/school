<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    /**
     * Display a listing of parents
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('parents');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('full_name', 'LIKE', "%{$search}%")
                      ->orWhere('spouse_name', 'LIKE', "%{$search}%")
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%")
                      ->orWhere('cnic', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by occupation
            if ($request->has('occupation')) {
                $query->where('parent_occupation', $request->occupation);
            }
            
            $parents = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Parents retrieved successfully',
                'data' => $parents
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving parents',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created parent
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'parent_occupation' => 'required|string',
            'spouse_name' => 'required|string|max:255',
            'spouse_occupation' => 'required|string',
            'cnic' => 'required|string|unique:parents,cnic',
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'email' => 'nullable|email|unique:parents,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('parent_photos', 'public');
            }

            $parentId = DB::table('parents')->insertGetId([
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'parent_occupation' => $request->parent_occupation,
                'spouse_name' => $request->spouse_name,
                'spouse_occupation' => $request->spouse_occupation,
                'cnic' => $request->cnic,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $photoPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $parent = DB::table('parents')->where('id', $parentId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Parent created successfully',
                'data' => $parent
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating parent',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified parent
     */
    public function show($id)
    {
        try {
            $parent = DB::table('parents')->where('id', $id)->first();
            
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Parent retrieved successfully',
                'data' => $parent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving parent',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified parent
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'parent_occupation' => 'required|string',
            'spouse_name' => 'required|string|max:255',
            'spouse_occupation' => 'required|string',
            'cnic' => 'required|string|unique:parents,cnic,' . $id,
            'blood_group' => 'required|string',
            'religion' => 'required|string',
            'email' => 'nullable|email|unique:parents,email,' . $id,
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $parent = DB::table('parents')->where('id', $id)->first();
            
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent not found'
                ], 404);
            }

            DB::table('parents')->where('id', $id)->update([
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'parent_occupation' => $request->parent_occupation,
                'spouse_name' => $request->spouse_name,
                'spouse_occupation' => $request->spouse_occupation,
                'cnic' => $request->cnic,
                'blood_group' => $request->blood_group,
                'religion' => $request->religion,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'updated_at' => now(),
            ]);

            $updatedParent = DB::table('parents')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Parent updated successfully',
                'data' => $updatedParent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating parent',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified parent
     */
    public function destroy($id)
    {
        try {
            $parent = DB::table('parents')->where('id', $id)->first();
            
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent not found'
                ], 404);
            }

            DB::table('parents')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Parent deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting parent',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get children of the specified parent
     */
    public function children($id)
    {
        try {
            $parent = DB::table('parents')->where('id', $id)->first();
            
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent not found'
                ], 404);
            }

            // Get children based on parent name
            $children = DB::table('admission_forms')
                ->where('parent_name', $parent->full_name)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Children retrieved successfully',
                'data' => $children
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving children',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed parent information
     */
    public function details($id)
    {
        try {
            $parent = DB::table('parents')->where('id', $id)->first();
            
            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent not found'
                ], 404);
            }

            // Get children
            $children = DB::table('admission_forms')
                ->where('parent_name', $parent->full_name)
                ->get();

            // Get fee information for children
            $fees = DB::table('challans')
                ->whereIn('full_name', $children->pluck('full_name'))
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Parent details retrieved successfully',
                'data' => [
                    'parent' => $parent,
                    'children' => $children,
                    'children_count' => $children->count(),
                    'fees' => $fees
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving parent details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
