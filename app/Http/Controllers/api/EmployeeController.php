<?php

namespace App\Http\Controllers\api;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Http\Requests\EmployeeRequest;
use App\Http\Resources\EmployeeResource;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Employee::orderByDesc('created_at');

        $employees = $query->paginate(10);


        return ResponseHelper::success(EmployeeResource::collection($employees));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployee $request)
    {
        $employee = new Employee();
        $employee->full_name = $request->full_name;
        $employee->company_id = $request->company_id;
        $employee->email = $request->email;
        $employee->phone = $request->phone;

        $employee->save();

        return ResponseHelper::success([], 'successfully created');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Employee::where('id', $id)->firstOrFail();
        return ResponseHelper::success(new EmployeeResource($company));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->full_name = $request->full_name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->company_id = $request->company_id;

        $employee->update();

       return ResponseHelper::success([], 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return ResponseHelper::success([], 'successfully deleted');
    }
}
