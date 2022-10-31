<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('patient/login');
});

//login patient page
Route::post('/patient/registerProcess', [PatientController::class, 'registerProcess'])->name('patient.registerProcess');
Route::post('/patient/loginProcess', [PatientController::class, 'loginProcess'])->name('patient.loginProcess');
Route::get('/patient/logout', [PatientController::class, 'logout'])->name('patient.logout');
//login doctor page
Route::post('/doctor/doctorLoginProcess', [DoctorController::class, 'doctorLoginProcess'])->name('doctor.doctorLoginProcess');
Route::get('/doctor/logout', [DoctorController::class, 'logout'])->name('doctor.logout');
//login admin page
Route::post('/admin/adminLoginProcess', [AdminController::class, 'adminLoginProcess'])->name('admin.adminLoginProcess');
Route::post('/admin/adminRegisterProcess', [AdminController::class, 'adminRegisterProcess'])->name('admin.adminRegisterProcess');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::group(['middleware'=>['AdminCheck']], function(){
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    Route::get('/admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('/admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/confirmRemoveDoctor/{doctor_id}', [AdminController::class, 'confirmRemoveDoctor'])->name('admin.confirmRemoveDoctor');
    Route::post('/admin/addNewDoctor', [AdminController::class, 'addNewDoctor'])->name('admin.addNewDoctor');
    Route::post('/admin/confirmRemovePatient/{patient_id}', [AdminController::class, 'confirmRemovePatient'])->name('admin.confirmRemovePatient');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/updateAdminInformation/{id}', [AdminController::class, 'updateAdminInformation'])->name('admin.updateAdminInformation');
    Route::post('/admin/updateAdminPassword/{id}', [AdminController::class, 'updateAdminPassword'])->name('admin.updateAdminPassword');
    Route::post('/admin/updateAdminPicture/{id}', [AdminController::class, 'updateAdminPicture'])->name('admin.updateAdminPicture');
});

Route::group(['middleware'=>['PatientCheck']], function(){
    Route::get('/patient/register', [PatientController::class, 'register'])->name('patient.register');
    Route::get('/patient/login', [PatientController::class, 'login'])->name('patient.login');
    Route::get('/patient/dashboard', [AppointmentController::class, 'dashboard'])->name('patient.dashboard');
    Route::get('/patient/doctors', [DoctorController::class, 'doctors'])->name('patient.doctors');
    Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile');
    Route::get('/patient/settings', [PatientController::class, 'settings'])->name('patient.settings');
    Route::get('/patient/appointment', [AppointmentController::class, 'appointment'])->name('patient.appointment');
    Route::get('/patient/history', [AppointmentController::class, 'appointmentHistory'])->name('patient.history');
    Route::post('/patient/setAppointment', [AppointmentController::class, 'setAppointment'])->name('patient.setAppointment');
    Route::post('/patient/updateAppointmentProcess/{appointment_id}', [AppointmentController::class, 'updateAppointmentProcess'])->name('patient.updateAppointmentProcess');
    Route::post('/patient/cancelAppointmentProcess/{appointment_id}', [AppointmentController::class, 'cancelAppointmentProcess'])->name('patient.cancelAppointmentProcess');
    Route::post('/patient/updateInformation/{patient_id}', [PatientController::class, 'updateInformation'])->name('patient.updateInformation');
    Route::post('/patient/updatePatientPassword/{patient_id}', [PatientController::class, 'updatePatientPassword'])->name('patient.updatePatientPassword');
    Route::post('/patient/updatePicture/{patient_id}', [PatientController::class, 'updatePicture'])->name('patient.updatePicture');
});

Route::group(['middleware'=>['DoctorCheck']], function(){
    Route::get('/doctor/login', [DoctorController::class, 'login'])->name('doctor.login');
    Route::get('/doctor/register', [DoctorController::class, 'register'])->name('doctor.register');
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::get('/doctor/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
    Route::get('/doctor/settings', [DoctorController::class, 'settings'])->name('doctor.settings');
    Route::get('/doctor/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/doctor/history', [DoctorController::class, 'patientsHistory'])->name('doctor.history');
    Route::post('/doctor/confirmAppointmentRequest/{appointment_id}', [AppointmentController::class, 'confirmAppointmentRequest'])->name('doctor.confirmAppointmentRequest');
    Route::post('/doctor/doneAppointment/{appointment_id}', [AppointmentController::class, 'doneAppointment'])->name('doctor.doneAppointment');
    Route::post('/doctor/updateDoctorInformation/{doctor_id}', [DoctorController::class, 'updateDoctorInformation'])->name('doctor.updateDoctorInformation');
    Route::post('/doctor/updateDoctorPassword/{doctor_id}', [DoctorController::class, 'updateDoctorPassword'])->name('doctor.updateDoctorPassword');
    Route::post('/doctor/updateDoctorPicture/{doctor_id}', [DoctorController::class, 'updateDoctorPicture'])->name('doctor.updateDoctorPicture');
});



