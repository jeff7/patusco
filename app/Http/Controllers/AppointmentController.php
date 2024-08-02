<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;


class AppointmentController extends Controller
{
    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $appointment = $this->appointmentRepository->with(['user']);
        return response()->json($appointment, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        //
        $appointment = $request->validated();
        $appointment = $this->appointmentRepository->create($appointment);
        return response()->json($appointment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $appointment = $this->appointmentRepository->find($id, ['user']);;
        return response()->json($appointment, 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateAppointmentRequest $request, $id)
    {
        //
        $appointment = $request->validated();
        $appointment = $this->appointmentRepository->update($id, $appointment);
        return response()->json($appointment, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $appointment = $this->appointmentRepository->delete($id);
        return response()->json([ 'message' => 'deletado' ] , 200);
    }
}
