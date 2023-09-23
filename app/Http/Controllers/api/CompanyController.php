<?php

namespace App\Http\Controllers\api;

use App\Models\Media;
use App\Models\Company;
use Illuminate\Http\Request;
use App\helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CompanyDetailResource;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::orderByDesc('created_at');

        $companies = $query->paginate(10);


        return ResponseHelper::success(CompanyResource::collection($companies));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required',
            'website' => 'required',
            ],
        );

        DB::beginTransaction();

        try {
            $file_name= null;
        if($request->hasFile('logo'))
        {
            $file= $request->file('logo');
            $file_name= uniqid() . '-' . date('Y-m-d-H-i-s') . '.' . $file->getClientOriginalExtension();
            Storage::put('media/' .$file_name, file_get_contents($file));
        }

        $company = new Company();
        $company->name= $request->name;
        $company->email= $request->email;
        $company->logo= $file_name;
        $company->website= $request->website;

        $company->save();

        DB::commit();
        return ResponseHelper::success([], 'successfully created');
        } catch (Exception $e) {
            DB::rollback();
            return ResponseHelper::fail($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::where('id', $id)->firstOrFail();
        return ResponseHelper::success(new CompanyDetailResource($company));
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
        $company = Company::findOrFail($id);

         //get old photo
         $img_file_name = $company->logo;

         //check if new photo insert or not
         if($request->hasFile('logo'))
         {
             Storage::disk('public')->delete('media/' . $company->logo); //Delete Old photo

             //Insert new photo
             $img_file= $request->file('logo');
             $img_file_name= uniqid().'-'.time().'.'.$img_file->getClientOriginalExtension();
             Storage::disk('public')->put('img/' .$img_file_name, file_get_contents($img_file));
         }

        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $img_file_name;
        $company->website = $request->website;

        $company->update();

        return ResponseHelper::success([], 'successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return ResponseHelper::success([], 'successfully deleted');
    }
}
