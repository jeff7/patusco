<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;


class UserController extends Controller
{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = $this->userRepository->with(['appointments']);
        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        $userValidated = $request->validated();
        $user = $this->userRepository->create($userValidated);
        if ($user) {
            $credentials = $request->only('email', 'password');
            $token = auth()->attempt($credentials);
            if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

            $user = auth()->user();
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ],201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $user = $this->userRepository->find($id, ['appointments']);;
        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function getUserDoctors()
    {
        //
        $user = $this->userRepository->findDoctors();
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(UpdateUserRequest $request, $id)
    {
        //
        $userValidated = $request->validated();
        $user = $this->userRepository->update($id, $userValidated);
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->userRepository->delete($id);
        return response()->json([ 'message' => 'deletado' ] , 200);
    }
}
