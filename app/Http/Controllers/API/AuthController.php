<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Passport\Passport;
use Illuminate\Support\Str;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => ['required', 'email', 'unique:users', 'regex:/^[\w\.\-]+@(gmail\.com|hotmail\.com)$/i'],
            'password' => 'required|confirmed|min:8',
            'phone' => ['required', 'regex:/^\+963\d{9}$/'],
        ]);

        try {
            DB::beginTransaction();

            $existingUser = User::where('phone', $validatedData['phone'])->first();
            if ($existingUser) {
                return response(['error' => 'رقم الهاتف موجود بالفعل'], 422);
            }

            $validatedData['password'] = bcrypt($request->password);

            $user = User::create($validatedData);

            $accessToken = $user->createToken('authToken')->accessToken;

            DB::commit();

            return response(['user' => $user, 'access_token' => $accessToken]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['error' => 'Failed to register user.', 'reason' => $e], 500);
        }
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $accessToken = $user->createToken('authToken')->accessToken;
            return response(['user' => $user, 'access_token' => $accessToken]);
        }

        return response(['error' => 'Invalid credentials']);
    }

    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthinticated'], 403);
        }

        return response()->json([
            'status' => true,
            'message' => "User data",
            'data' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
            'phone' => ['sometimes', 'regex:/^\+963\d{9}$/'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update user information
        $user = Auth::user();
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        $user->save();

        return response()->json(['message' => 'تم تحديث المعلومات الشخصية بنجاح', 'user' => $user]);
    }

    public function logout(Request $request)
    {
        // get token value
        $token = $request->user()->token();

        // revoke this token value
        $token->revoke();

        return response()->json([
            "status" => true,
            "message" => "User logged out successfully"
        ]);
    }

    public function changePassword(Request $request)
    {


        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'غير مصرح لك بتعديل كلمة المرور'], 403);
        }


        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'كلمة المرور الحالية غير صحيحة'], 400);
        }


        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'تم تغيير كلمة المرور بنجاح'], 200);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }
    public function ResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(str::random(60));

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }
    public function destroy()
    {
        $user = Auth::user();

        if ($user) {
            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        }

        return response()->json(['error' => 'User not found'], 404);
    }
    public function switchAccount(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Revoke the old token using the token from the request
            $requestToken = $request->bearerToken();
            if ($requestToken) {
                $currentUser = Auth::user();
                $currentUser->token()->revoke();
            }

            // Create a new token for the new account
            $accessToken = $user->createToken('authToken')->accessToken;

            return response(['user' => $user, 'access_token' => $accessToken]);
        }

        return response(['error' => 'Invalid credentials'], 401);
    }

    public function allUsers(){
        $users=User::all();
            return response()->json($users);

    }

    public function userDetails($id){
        $users=User::findOrFail($id)->get();
        return response()->json($users);

    }

    public function logindashboard(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Check role_id condition (assuming role_id is nullable)
            if ($user->role_id == 2 || $user->role_id == 3) {
                $accessToken = $user->createToken('authToken')->accessToken;
                return response(['user' => $user, 'access_token' => $accessToken]);
            } else {
                return response(['error' => 'Unauthorized access.'], 401);
            }
        }

        return response(['error' => 'Invalid credentials'], 401);
}
}
