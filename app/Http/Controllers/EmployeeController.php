<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor' => 'required|unique:employees,nomor',
            'nama' => 'required',
            'jabatan' => 'nullable',
            'talahir' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'created_by' => 'nullable',
        ]);

        $data['created_on'] = now();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee_photos', 's3');
            $data['photo_upload_path'] = Storage::disk('s3')->url($path);
        }

        $employee = Employee::create($data);
        Redis::set("emp_{$employee->nomor}", $employee->toJson());
        return response()->json($employee);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $data = $request->validate([
            'nama' => 'sometimes|required',
            'jabatan' => 'nullable',
            'talahir' => 'nullable|date',
            'photo' => 'nullable|image|max:2048',
            'updated_by' => 'nullable',
        ]);

        $data['updated_on'] = now();

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee_photos', 's3');
            $data['photo_upload_path'] = Storage::disk('s3')->url($path);
        }
        $employee->update($data);
        Redis::set("emp_{$employee->nomor}", $employee->toJson());

        return response()->json($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update([
            'deleted_on' => now()->toDateTimeString()
        ]);
        Redis::del("emp_{$employee->nomor}");
        return response()->json(['message' => 'Soft deleted']);
    }
}

