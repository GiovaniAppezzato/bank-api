<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        protected User $user,
    ) {}

    public function index(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = $this->user->newAccount($request);

            $user->address()->create([
                'city'         => $request->city,
                'neighborhood' => $request->neighborhood,
                'street'       => $request->street,
                'number'       => $request->number,
                'complement'   => $request->complement,
                'zip_code'     => $request->zip_code,
                'state'        => $request->state,
            ]);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $extension = $file->extension();

                $hash = md5($file->getClientOriginalName() . strtotime('now')) . "." . $extension;
                $file->storeAs('public/users', $hash);

                $user->photo = $hash;
                $user->save();
            }

            $credentials = $request->only('email', 'password');

            if(Auth::attempt($credentials)){
                /** @var User $user */
                $user = Auth::user();
                $token = $user->createToken('jwt');
            }

            DB::commit();

            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function confirmPassword(Request $request)
    {
        $password = $request['password'];

        if(Hash::check($password, Auth::user()->password)) {
            return response()->json([
                'status' => true,
            ], 200);
        }

        return response()->json([
            'status' => false,
        ], 200);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();
        $user->update($data);

        $photoPath = null;

        if ($request->hasFile('user.photo')) {
            $photoPath = $request->file('user.photo')->store('photos', Auth::id() . '.' . $request->file('user.photo')->getClientOrginalExtension(), 'public');
        }

        return response()->json([
            'success' => true,
            'user' => $user
        ], 200);
    }

    public function resetPasswordLogged(User $user, Request $request)
    {
        //TODO: Update if the old password is different and if both passwords are equal.

        $this->validate($request, [
            'new_password' => 'required|confirmed|min:8',
        ]);

        $newPassword = $request->input('new_password');

        $user->update([
            'password' => bcrypt($newPassword),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully',
        ], 200);
    }
}
