<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Doctors;
use App\Models\Patients;
use App\Models\Appointment;
use App\Models\CancelledAppointments;
use App\Models\appointmentHistory;

class AdminController extends Controller
{
    public function login(){
        return view('admin.login');
    }

    public function adminLoginProcess(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admindb = Admin::where('username', '=', $request->username)->first();

        if(!$admindb){
            return back()->with('error', 'We do not recognize your username.');
        }else{
            if(password_verify($request->password, $admindb->password)){
                $request->session()->put('LoggedAdmin', $admindb->id);
                return redirect()->route('admin.dashboard');
            }else{
                return back()->with('error', 'Incorrect password.');
            }
        }
    }

    public function logout(){
        session()->forget('LoggedAdmin');
        return redirect()->route('admin.login');
    }

    public function dashboard(){
        $data = ['LoggedAdmin'=>Admin::where('id', '=', session('LoggedAdmin'))->first()];
        $getTotalDoctors = Doctors::count();
        $getTotalPatients = Patients::count();
        //doctors all limit 5
        $doctors = Doctors::orderBy('doctor_id', 'desc')->limit(5)->get();
        $patients = Patients::orderBy('patient_id', 'desc')->limit(5)->get();
        return view('admin.dashboard', $data, compact('getTotalDoctors', 'getTotalPatients', 'doctors', 'patients'));
    }

    public function register(){
        return view('admin.register');
    }

    public function adminRegisterProcess(Request $request){
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:5',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin = new Admin;
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $save = $admin->save();

        if($save){
            return redirect()->route('admin.login')->with('success', 'New Admin has been successfully added to the database');
        }else{
            return back()->with('fail', 'Something went wrong, try again later');
        }
    }

    public function doctors(){
        $data = ['LoggedAdmin'=>Admin::where('id', '=', session('LoggedAdmin'))->first()];
        $doctors = Doctors::orderBy('doctor_id', 'desc')->get();
        $count = Doctors::count();
        return view('admin.doctors', $data, compact('doctors', 'count'));
    }

    function addNewDoctor(Request $request){
        $request->validate([
            'doctor_name' => 'required',
            'doctor_email' => 'required|email|unique:doctors',
            'doctor_phone' => 'required',
            'doctor_speciality' => 'required',
            'doctor_password' => 'required|min:6',
            'doctor_password_confirmation' => 'required|same:doctor_password',
        ]);

        $doctor = new Doctors();
        $doctor->doctor_name = $request->doctor_name;
        $doctor->doctor_email = $request->doctor_email;
        $doctor->doctor_phone = $request->doctor_phone;
        $doctor->doctor_speciality = $request->doctor_speciality;
        $doctor->password = bcrypt($request->doctor_password);
        $insertDoctor  = $doctor->save();

        if($insertDoctor){
            return redirect()->route('admin.doctors')->with('success', 'Doctor Registration Successful. Doctor can now login to the system.');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    public function confirmRemoveDoctor(Request $request, $doctor_id){
        $deleteAllAppointments = Appointment::where('doctor_id', $doctor_id)->delete();
        $delete = Doctors::where('doctor_id', $doctor_id)->delete();
        return redirect()->route('admin.doctors')->with('success', 'Doctor has been successfully removed from the the list.');
    }

    public function patients(){
        $data = ['LoggedAdmin'=>Admin::where('id', '=', session('LoggedAdmin'))->first()];
        $patients = Patients::orderBy('patient_id', 'desc')->get();
        $count = Patients::count();
        return view('admin.patients', $data, compact('patients', 'count'));
    }

    public function confirmRemovePatient(Request $request, $patient_id){
        $deleteAllAppointments = Appointment::where('patient_id', $patient_id)->delete();
        $deleteAllHistory = appointmentHistory::where('patient_id', $patient_id)->delete();
        $deleteAllCancelled = CancelledAppointments::where('patient_id', $patient_id)->delete();
        $delete = Patients::where('patient_id', $patient_id)->delete();
        return redirect()->route('admin.patients')->with('success', 'Patient has been successfully removed from the the list.');
    }

    public function profile(){
        $data = ['LoggedAdmin'=>Admin::where('id', '=', session('LoggedAdmin'))->first()];
        return view('admin.profile', $data);
    }

    public function settings(){
        $data = ['LoggedAdmin'=>Admin::where('id', '=', session('LoggedAdmin'))->first()];
        return view('admin.settings', $data);
    }

    public function updateAdminInformation(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id.',id',
            'username' => 'required|unique:admins,username,'.$id.',id',
        ]);
        $admin = Admin::where('id', '=', $id)->first();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->username = $request->input('username');
        $updateAdmin = $admin->save();
        if($updateAdmin){
            return redirect()->route('admin.settings')->with('success', 'Your Information Updated Successfully');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    public function updateAdminPicture(Request $request, $id){
        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $admin = Admin::where('id', '=', $id)->first();
        $admin->picture = $request->file('picture');
        $extension = $admin->picture->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $admin->picture->move('uploads/admins/', $filename);
        $admin->picture = $filename;

        $updateAdmin = $admin->update();
        if($updateAdmin){
            return redirect()->route('admin.settings')->with('pictureUpdated', 'Picture updated successfully');
        }
        else{
            return redirect()->back()->with('errorUpload', 'Something went wrong, please try again');
        }
    }

    public function updateAdminPassword(Request $request, $id){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        if(password_verify($request->old_password, Admin::where('id', '=', $id)->first()->password)){
            $admin = Admin::where('id', '=', $id)->first();
            $admin->password = bcrypt($request->new_password);
            $updateAdmin = $admin->update();
            if($updateAdmin){
                return redirect()->route('admin.settings')->with('passwordUpdated', 'Password updated successfully');
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong, please try again');
            }
        }
        else{
            return redirect()->back()->with('incorrectOldPassword', 'Incorrect Old Password, please try again');
        }
    }
}
