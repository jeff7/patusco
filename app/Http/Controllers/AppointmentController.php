<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        try {
            $user = auth()->user();
            $filters = [];

            $type_animal = $request->query('tipo');
            $date = $request->query('data');


            if ($user->user_type == 'D')
                $filters = ['user_id' => $user->id];
            
            if ($type_animal)
                $filters['animal_type'] = $type_animal;
            
            if ($date)
                $filters['appointment_date'] = $date;

            $appointment = $this->appointmentRepository->with(['user'],$filters);

            return response()->json($appointment, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'message' => $th ] , 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        //
        
        try {
            $appointment = $request->validated();
            $appointment = $this->appointmentRepository->create($appointment);
            return response()->json($appointment, 201);
        } catch (\Throwable $th) {
            return response()->json([ 'message' => $th ] , 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        try {
            $appointment = $this->appointmentRepository->find($id, ['user']);;
            return response()->json($appointment, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'message' => $th ] , 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateAppointmentRequest $request, $id)
    {
        //
        try {
            $appointment = $request->validated();
            $appointment = $this->appointmentRepository->update($id, $appointment);
            return response()->json($appointment, 200);
        } catch (\Throwable $th) {
            return response()->json([ 'message' => $th ] , 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = auth()->user();
            if($user->user_type == 'D')
                return response()->json([ 'message' => 'Voce não tem permissão para deletar' ] , 401);
            $appointment = $this->appointmentRepository->delete($id);
            return response()->json([ 'message' => 'deletado' ] , 200);
        } catch (\Throwable $th) {
             return response()->json([ 'message' => $th ] , 500);
        }
        
    }
}
