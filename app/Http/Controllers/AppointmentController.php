<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patients;
use App\Models\Doctors;
use App\Models\Appointment;
use App\Models\CancelledAppointments;
use App\Models\appointmentHistory;

class AppointmentController extends Controller
{

    //appointment view
    function appointment(){
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first(), 'doctors'=>Doctors::all()];
        return view('patient.appointment', $data);
    }

    //patient appointment dashboard
    function dashboard(){
        $getAppointments = Appointment::where('patient_id', '=', session('LoggedPatient'))->get();
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first(), 'appointments'=>$getAppointments];

        return view('patient.dashboard', $data, compact('getAppointments'));
    }

    function appointmentHistory(){
        $getAllCancelledAppointments = CancelledAppointments::where('patient_id', '=', session('LoggedPatient'))->get();
        $getDoneAppointments = appointmentHistory::where('patient_id', '=', session('LoggedPatient'))->get();
        //merge the cancelled and done appointments
        $getAppointments = $getAllCancelledAppointments->merge($getDoneAppointments);
        $data = ['LoggedPatient'=>Patients::where('patient_id', '=', session('LoggedPatient'))->first(), 'appointments'=>$getAppointments];

        return view('patient.history', $data, compact('getAppointments'));
    }

    //create appointment
    function setAppointment(Request $request){
        $request->validate([
            'patient_id' => 'required',
            'patient_name' => 'required',
            'doctor_id' => 'required',
            'doctor_name' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
        ]);

        //check if the logged in patient have completed their profile
        $patient = Patients::where('patient_id', '=', session('LoggedPatient'))->first();
        //prevent patient to set appointment on the current date
        $currentDate = date('Y-m-d');
        //limit appointment to two per patient
        $limitAppointment = Appointment::where('patient_id', '=', $request->patient_id)->count();
        // check if patient has already an appointment in the doctor
        $checkDoctorsAppointment = Appointment::where('patient_id', '=', $request->patient_id)->where('doctor_id', '=', $request->doctor_id)->count();
        //check if patient has already an appointment in the same date and time
        $checkAppointment = Appointment::where('patient_id', '=', $request->patient_id)->where('appointment_date', '=', $request->appointment_date)->where('appointment_time', '=', $request->appointment_time)->first();

        if($patient->date_of_birth == null || $patient->address == null || $patient->address == null){
            return redirect()->back()->with('error', 'Please complete your profile to set an appointment in Settings.');
        }
        else{
            if($request->doctor_id == '0' || $request->doctor_name == '0'){
                return redirect()->back()->with('error', 'There is no doctor available at the moment. Please try again later.');
            }
            else{
                if($request->appointment_date == $currentDate){
                    return redirect()->back()->with('error', 'Sorry, you can\'t set an appointment today. Try another date');
                }
                else{
                    if($limitAppointment >= 2){
                        return redirect()->back()->with('error', 'You have already set two appointments');
                    }
                    else{
                        if($checkDoctorsAppointment >= 2){
                            return redirect()->back()->with('error', 'You have already set an appointment in this doctor');
                        }
                        else{
                            if($checkAppointment){
                                return redirect()->back()->with('error', 'You have already set an appointment in this date and time');
                            }
                            else{

                                $doctorName = Doctors::where('doctor_id', '=', $request->doctor_id)->first();
                                $doctorName = $doctorName->doctor_name;

                                $appointment = new Appointment();
                                $appointment->patient_id = $request->patient_id;
                                $appointment->patient_name = $request->patient_name;
                                $appointment->doctor_id = $request->doctor_id;
                                $appointment->doctor_name = $doctorName;
                                $appointment->appointment_date = $request->appointment_date;
                                $appointment->appointment_time = $request->appointment_time;
                                $appointment->appointment_status = 'pending';

                                $insertAppointment = $appointment->save();
                                if($insertAppointment){
                                    return redirect()->route('patient.dashboard')->with('success', 'Appointment set successfully');
                                }
                                else{
                                    return redirect()->back()->with('error', 'Something went wrong, please try again');
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function confirmAppointmentRequest(Request $request, $appointment_id){
        $appointment = Appointment::where('appointment_id', '=', $appointment_id)->first();
        $appointment->appointment_status = 'confirmed';
        $confirmAppointment = $appointment->save();
        if($confirmAppointment){
            return redirect()->route('doctor.appointments')->with('success', 'Appointment confirmed successfully');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    function doneAppointment(Request $request, $appointment_id){
        $appointment = Appointment::where('appointment_id', '=', $request->appointment_id)->first();
        $appointment->appointment_status = 'done';
        $doneAppointment = $appointment->save();

        if($doneAppointment){
            $addToHistory = new appointmentHistory();
            $addToHistory->appointment_id = $appointment->appointment_id;
            $addToHistory->patient_id = $appointment->patient_id;
            $addToHistory->patient_name = $appointment->patient_name;
            $addToHistory->doctor_id = $appointment->doctor_id;
            $addToHistory->doctor_name = $appointment->doctor_name;
            $addToHistory->appointment_date = $appointment->appointment_date;
            $addToHistory->appointment_time = $appointment->appointment_time;
            $addToHistory->appointment_status = $appointment->appointment_status;
            $addToHistory->remarks = $request->input('remarks');
            $saveToHistory = $addToHistory->save();

            if($saveToHistory){
                $removeAppointment = Appointment::where('appointment_id', '=', $request->appointment_id)->delete();
                if($removeAppointment){
                    return redirect()->route('doctor.appointments')->with('success', 'Appointment done successfully');
                }
                else{
                    return redirect()->back()->with('error', 'Something went wrong, please try again');
                }
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong, please try again');
            }
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }


    //update appointment
    function updateAppointmentProcess(Request $request, $appointment_id){
        $appointment = Appointment::where('appointment_id', '=', $appointment_id)->first();
        $appointment->doctor_id = $request->input('doctor_id');
        $appointment->appointment_date = $request->input('appointment_date');
        //format to sql time format
        $appointment->appointment_time = date('H:i:s', strtotime($request->input('appointment_time')));
        $updateAppointment = $appointment->update();
        if($updateAppointment){
            return redirect()->route('patient.dashboard')->with('success', 'Appointment updated successfully');
        }
        else{
            return redirect()->back()->with('error', 'Something went wrong, please try again');
        }
    }

    //cancel appointment
    function cancelAppointmentProcess(Request $request, $appointment_id){
        //limit cancel of appointment to two per patient
        $limitCancel = CancelledAppointments::where('patient_id', '=', $request->patient_id)->count();
        if($limitCancel >= 2){
            return redirect()->back()->with('error', 'You have reached the limit of cancelling appointments');
        }
        else{
            $appointment = Appointment::where('appointment_id', '=', $appointment_id)->first();
            $appointment->appointment_status = 'cancelled';
            $cancelAppointment = $appointment->update();
            if($cancelAppointment)
            {
                $cancelledAppointment = new CancelledAppointments();
                $cancelledAppointment->appointment_id = $appointment_id;
                $cancelledAppointment->patient_id = $appointment->patient_id;
                $cancelledAppointment->patient_name = $appointment->patient_name;
                $cancelledAppointment->doctor_id = $appointment->doctor_id;
                $cancelledAppointment->doctor_name = $appointment->doctor_name;
                $cancelledAppointment->appointment_date = $appointment->appointment_date;
                $cancelledAppointment->appointment_time = $appointment->appointment_time;
                $cancelledAppointment->appointment_status = $appointment->appointment_status;
                $cancelledAppointment->reason = $request->input('reason');
                $cancelledAppointment->specify_reason = $request->input('specify_reason');
                $cancelAppointment = $cancelledAppointment->save();

                $deleteAppointment = Appointment::where('appointment_id', '=', $appointment_id)->delete();
                return redirect()->route('patient.dashboard')->with('success', 'Appointment cancelled successfully');
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong, please try again');
            }
        }
    }
}
