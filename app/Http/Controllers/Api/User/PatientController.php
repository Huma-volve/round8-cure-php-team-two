<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\UpdatePatientPasswordRequest;
use App\Http\Requests\Patient\UpdatePatientRequest;
use App\Utils\ImageManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    //show patient profile
        public function show(Request $request)
    {
        $patient = $request->user(); // Sanctum authenticated patient
        return apiResponse(200, 'Patient profile retrieved successfully', $patient);
    }

    public function update(UpdatePatientRequest $request)
    {
    $patient = $request->user();

    $data = $request->only(['name', 'email', 'gender', 'birthdate']);

    if ($request->hasFile('image')) {
        ImageManagement::uploadImage($request, $patient);
    }

    $patient->update($data);
    
    return apiResponse(200, 'Profile updated successfully', $patient->fresh());
}


    //update password
    public function updatePassword(UpdatePatientPasswordRequest $request)
    {
        $patient = $request->user();

        if (!Hash::check($request->current_password, $patient->password)) {
            return apiResponse(422, 'Current password is incorrect');
        }

        $patient->password = Hash::make($request->password);
        $patient->save();
        return apiResponse(200, 'Password updated successfully');
    }

}
