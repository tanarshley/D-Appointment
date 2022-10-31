<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctors;
use App\Models\Patients;
use App\Models\Appointment;
use App\Models\CancelledAppointments;
use App\Models\AppointmentHistory;

class DoctorController extends Controller
{
    function login(){
        return view('doctor.login');
    }

    function register(){
        return view('doctor.register');
    }

    function dashboard(){
        $data = ['LoggedDoctor'=>Doctors::where('doctor_id', '=', session('LoggedDoctor'))->first(), 'patients'=>Patients::all()];
        //get the total of all patients from appointments table by doctor_id
        $totalPatients = Appointment::where('appointment_status', '=', 'pending')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $confirmedAppointments = Appointment::where('appointment_status', '=', 'confirmed')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $successAppointments = AppointmentHistory::where('appointment_status', '=', 'done')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $pendingAppointments = Appointment::where('appointment_status', '=', 'pending')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $doneAppointments = AppointmentHistory::where('appointment_status', '=', 'done')->where('doctor_id', '=', session('LoggedDoctor'))->orderBy('updated_at', 'desc')->take(5)->get();
        $todaysAppointment = Appointment::where('doctor_id', '=', session('LoggedDoctor'))->where('appointment_date', '=', date('Y-m-d'))->count();
        $latestAppointments = Appointment::where('doctor_id', '=', session('LoggedDoctor'))->orderBy('appointment_date', 'desc')->orderBy('appointment_time', 'desc')->take(5)->get();
        return view('doctor.dashboard', $data, compact('totalPatients', 'pendingAppointments','confirmedAppointments', 'successAppointments', 'doneAppointments' ,'latestAppointments', 'todaysAppointment'));
    }

    function profile(){
        $data = ['LoggedDoctor'=>Doctors::where('doctor_id', '=', session('LoggedDoctor'))->first(), 'patients'=>Patients::all()];
        return view('doctor.profile', $data);
    }

    function patientsHistory(){
        $data = ['LoggedDoctor'=>Doctors::where('doctor_id', '=', session('LoggedDoctor'))->first(), 'patients'=>Patients::all()];
        $historyAppointments = AppointmentHistory::where('doctor_id', '=', session('LoggedDoctor'))->orderBy('updated_at', 'desc')->get();
        $countHistoryAppointments = AppointmentHistory::where('doctor_id', '=', session('LoggedDoctor'))->count();
        $countAssessedPatientsToday = AppointmentHistory::where('doctor_id', '=', session('LoggedDoctor'))->where('updated_at', '>=', date('Y-m-d'))->count();
        return view('doctor.history', $data, compact('historyAppointments', 'countHistoryAppointments', 'countAssessedPatientsToday'));
    }

    function settings(){
        $data = ['LoggedDoctor'=>Doctors::where('doctor_id', '=', session('LoggedDoctor'))->first(), 'patients'=>Patients::all()];
        return view('doctor.settings', $data);
    }

    function appointments(){
        $data = ['LoggedDoctor'=>Doctors::where('doctor_id', '=', session('LoggedDoctor'))->first(), 'patients'=>Patients::all()];
        $totalPatients = Appointment::where('appointment_status', '=', 'confirmed')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $confirmedAppointments = Appointment::where('appointment_status', '=', 'confirmed')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $successAppointments = AppointmentHistory::where('appointment_status', '=', 'done')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $pendingAppointments = Appointment::where('appointment_status', '=', 'pending')->where('doctor_id', '=', session('LoggedDoctor'))->count();
        $todaysAppointment = Appointment::where('doctor_id', '=', session('LoggedDoctor'))->where('appointment_date', '=', date('Y-m-d'))->count();
        $allAppointments = Appointment::where('doctor_id', '=', session('LoggedDoctor'))->orderBy('created_at', 'desc')->get();
        return view('doctor.appointments', $data, compact('totalPatients', 'pendingAppointments','confirmedAppointments', 'successAppointments', 'allAppointments', 'todaysAppointment'));
    }
    //
    function doctors(){
        //get all doctors data
        $doctors = Doctors::all();
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first(), 'doctors'=>$doctors];
        return view('patient.doctors', $data);
    }

    function doctorLoginProcess(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $doctor = Doctors::where('doctor_email', '=', $request->email)->first();
        if(!$doctor){
            return redirect()->back()->with('error', 'Sorry, we couldn\'t find your account');
        }
        else{
            if(password_verify($request->password, $doctor->password)){
                $request->session()->put('LoggedDoctor', $doctor->doctor_id);
                return redirect()->route('doctor.dashboard');
            }
            else{
                return redirect()->back()->with('error', 'Incorrect password. Try again.');
            }
        }
    }

    function updateDoctorInformation(Request $request, $doctor_id){
        $request->validate([
            'doctor_name' => 'required',
            'doctor_email' => 'required|email|unique:doctors,doctor_email,'.$doctor_id.',doctor_id',
            'doctor_phone' => 'required',
            'doctor_speciality' => 'required',
        ]);
        $doctor = Doctors::where('doctor_id', '=', $doctor_id)->first();
        $doctor->doctor_name = $request->input('doctor_name');
        $doctor->doctor_email = $request->input('doctor_email');
        $doctor->doctor_phone = $request->input('doctor_phone');
        $doctor->doctor_speciality = $request->input('doctor_speciality');
        $updateDoctor = $doctor->save();
        if($updateDoctor){
            return redirect()->route('doctor.settings')->with('success', 'Your Information Updated Successfully');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    function updateDoctorPassword(Request $request, $doctor_id){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        if(password_verify($request->old_password, Doctors::where('doctor_id', '=', $doctor_id)->first()->password)){
            $doctor = Doctors::where('doctor_id', '=', $doctor_id)->first();
            $doctor->password = bcrypt($request->new_password);
            $updateDoctor = $doctor->update();
            if($updateDoctor){
                return redirect()->route('doctor.settings')->with('passwordUpdated', 'Password updated successfully');
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong, please try again');
            }
        }
        else{
            return redirect()->back()->with('incorrectOldPassword', 'Incorrect Old Password, please try again');
        }
    }

    function updateDoctorPicture(Request $request, $doctor_id){
        $request->validate([
            'doctor_picture' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $doctor = Doctors::where('doctor_id', '=', $doctor_id)->first();
        $doctor->doctor_picture = $request->file('doctor_picture');
        $extension = $doctor->doctor_picture->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $doctor->doctor_picture->move('uploads/doctors/', $filename);
        $doctor->doctor_picture = $filename;

        $updateDoctor = $doctor->update();
        if($updateDoctor){
            return redirect()->route('doctor.settings')->with('pictureUpdated', 'Picture updated successfully');
        }
        else{
            return redirect()->back()->with('errorUpload', 'Something went wrong, please try again');
        }
    }

    function logout(){
        session()->forget('LoggedDoctor');
        return redirect()->route('doctor.login');
    }
}
