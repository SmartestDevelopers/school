<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransportController extends Controller
{
    /**
     * Display a listing of transport routes
     */
    public function index(Request $request)
    {
        try {
            $query = DB::table('transports');
            
            // Search functionality
            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('route_name', 'LIKE', "%{$search}%")
                      ->orWhere('vehicle_number', 'LIKE', "%{$search}%")
                      ->orWhere('driver_name', 'LIKE', "%{$search}%")
                      ->orWhere('phone_number', 'LIKE', "%{$search}%");
                });
            }
            
            // Filter by route
            if ($request->has('route')) {
                $query->where('route_name', $request->route);
            }
            
            $transports = $query->paginate($request->get('per_page', 15));
            
            return response()->json([
                'success' => true,
                'message' => 'Transport routes retrieved successfully',
                'data' => $transports
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving transport routes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created transport route
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|unique:transports,vehicle_number',
            'driver_name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:transports,license_number',
            'phone_number' => 'required|string',
            'capacity' => 'nullable|integer|min:1',
            'fare' => 'nullable|numeric|min:0',
            'route_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $transportId = DB::table('transports')->insertGetId([
                'route_name' => $request->route_name,
                'vehicle_number' => $request->vehicle_number,
                'driver_name' => $request->driver_name,
                'license_number' => $request->license_number,
                'phone_number' => $request->phone_number,
                'capacity' => $request->capacity,
                'fare' => $request->fare,
                'route_description' => $request->route_description,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $transport = DB::table('transports')->where('id', $transportId)->first();

            return response()->json([
                'success' => true,
                'message' => 'Transport route created successfully',
                'data' => $transport
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating transport route',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified transport route
     */
    public function show($id)
    {
        try {
            $transport = DB::table('transports')->where('id', $id)->first();
            
            if (!$transport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transport route not found'
                ], 404);
            }

            // Get students using this transport
            $students = DB::table('admission_forms')
                ->where('transport_id', $id)
                ->get(['id', 'full_name', 'class', 'section', 'phone']);

            return response()->json([
                'success' => true,
                'message' => 'Transport route retrieved successfully',
                'data' => [
                    'transport' => $transport,
                    'students' => $students,
                    'student_count' => $students->count()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving transport route',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified transport route
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'route_name' => 'required|string|max:255',
            'vehicle_number' => 'required|string|unique:transports,vehicle_number,' . $id,
            'driver_name' => 'required|string|max:255',
            'license_number' => 'required|string|unique:transports,license_number,' . $id,
            'phone_number' => 'required|string',
            'capacity' => 'nullable|integer|min:1',
            'fare' => 'nullable|numeric|min:0',
            'route_description' => 'nullable|string',
            'status' => 'required|string|in:active,inactive,maintenance',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $transport = DB::table('transports')->where('id', $id)->first();
            
            if (!$transport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transport route not found'
                ], 404);
            }

            DB::table('transports')->where('id', $id)->update([
                'route_name' => $request->route_name,
                'vehicle_number' => $request->vehicle_number,
                'driver_name' => $request->driver_name,
                'license_number' => $request->license_number,
                'phone_number' => $request->phone_number,
                'capacity' => $request->capacity,
                'fare' => $request->fare,
                'route_description' => $request->route_description,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

            $updatedTransport = DB::table('transports')->where('id', $id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Transport route updated successfully',
                'data' => $updatedTransport
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating transport route',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified transport route
     */
    public function destroy($id)
    {
        try {
            $transport = DB::table('transports')->where('id', $id)->first();
            
            if (!$transport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transport route not found'
                ], 404);
            }

            // Check if any students are using this transport
            $studentsCount = DB::table('admission_forms')
                ->where('transport_id', $id)
                ->count();

            if ($studentsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete transport route with assigned students'
                ], 422);
            }

            DB::table('transports')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Transport route deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting transport route',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get transport routes by route name
     */
    public function byRoute($route)
    {
        try {
            $transports = DB::table('transports')
                ->where('route_name', 'LIKE', "%{$route}%")
                ->where('status', 'active')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Transport routes retrieved successfully',
                'data' => $transports
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving transport routes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get students using the specified transport
     */
    public function students($id)
    {
        try {
            $transport = DB::table('transports')->where('id', $id)->first();
            
            if (!$transport) {
                return response()->json([
                    'success' => false,
                    'message' => 'Transport route not found'
                ], 404);
            }

            $students = DB::table('admission_forms')
                ->where('transport_id', $id)
                ->get();

            // Group students by class and section
            $studentsByClass = $students->groupBy(function($student) {
                return $student->class . ' - ' . $student->section;
            });

            return response()->json([
                'success' => true,
                'message' => 'Transport students retrieved successfully',
                'data' => [
                    'transport' => $transport,
                    'students' => $students,
                    'students_by_class' => $studentsByClass,
                    'total_students' => $students->count(),
                    'capacity_utilization' => $transport->capacity ? 
                        round(($students->count() / $transport->capacity) * 100, 2) : 0
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving transport students',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
