<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Patients;
use App\Models\Doctors;
use App\Models\Appointment;
use App\Models\CancelledAppointments;

class PatientController extends Controller
{
    //
    function login(){
        return view('patient.login');
    }

    function register(){
        return view('patient.register');
    }

    function registerProcess(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:patients',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $patient = new Patients();
        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->password = bcrypt($request->password);
        $insertPatient  = $patient->save();

        if($insertPatient){
            return redirect()->route('patient.login')->with('success', 'Registration Successful. Please Login');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    function loginProcess(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $patient = Patients::where('email', '=', $request->email)->first();

        if(!$patient){
            return redirect()->back()->with('error', 'Sorry, we couldn\'t find your account');
        }
        else{
            if(password_verify($request->password, $patient->password)){
                $request->session()->put('LoggedPatient', $patient->patient_id);
                return redirect()->route('patient.dashboard');
            }
            else{
                return redirect()->back()->with('error', 'Incorrect Password, please try again');
            }
        }
    }

    function doctors(){
        $doctors = Doctors::all();
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first(), 'doctors'=>$doctors];
        return view('patient.doctors', $doctors);
    }

    function profile(){
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first()];
        return view('patient.profile', $data);
    }

    function settings(){
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first()];
        return view('patient.settings', $data);
    }

    function updateInformation(Request $request, $patient_id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:patients,email,'.$patient_id.',patient_id',
            'date_of_birth' => 'required',
            'phone_number' => 'required',
            'address' => 'required',
        ]);
        $patient = Patients::where('patient_id', '=', $patient_id)->first();
        $patient->name = $request->name;
        $patient->email = $request->email;
        $patient->date_of_birth = $request->date_of_birth;
        $patient->phone_number = $request->phone_number;
        $patient->address = $request->address;
        $updatePatient = $patient->save();
        if($updatePatient){
            return redirect()->route('patient.settings')->with('success', 'Information updated successfully');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    function updatePatientPassword(Request $request, $patient_id){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        if(password_verify($request->old_password, Patients::where('patient_id', '=', $patient_id)->first()->password)){
            $patient = Patients::where('patient_id', '=', $patient_id)->first();
            $patient->password = bcrypt($request->new_password);
            $updatePatient = $patient->update();
            if($updatePatient){
                return redirect()->route('patient.settings')->with('passwordUpdated', 'Password updated successfully');
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong, please try again');
            }
        }
        else{
            return redirect()->back()->with('incorrectOldPassword', 'Incorrect Old Password, please try again');
        }
    }

    function updatePicture(Request $request, $patient_id){
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $patient = Patients::where('patient_id', '=', $patient_id)->first();
        $patient->profile_picture = $request->file('profile_picture');
        $extension = $patient->profile_picture->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $patient->profile_picture->move('uploads/patients/', $filename);
        $patient->profile_picture = $filename;

        $updatePatient = $patient->update();
        if($updatePatient){
            return redirect()->route('patient.settings')->with('pictureUpdated', 'Picture updated successfully');
        }
        else{
            return redirect()->back()->with('errorUpload', 'Something went wrong, please try again');
        }
    }

    function logout(){
        session()->forget('LoggedPatient');
        return redirect()->route('patient.login');
    }
}
