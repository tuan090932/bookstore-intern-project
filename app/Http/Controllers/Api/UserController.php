<?php   
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\ApiUserExceptionHandler;
use App\Http\Requests\UpdateProfileRequest; // Đảm bảo sử dụng đúng Request
use Exception;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($user_id)
    {
        try {
            $user = User::findOrFail($user_id);
            return response()->json($user);
        } catch (Exception $ex) {
            return ApiUserExceptionHandler::handle($ex);
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);

            if ($request->has('user_name')) {
                $user->user_name = $request->user_name;
            }

            if ($request->has('email')) {
                $user->email = $request->email;
            }

            if ($request->has('name')) {
                $user->name = $request->name;
            }

            if ($request->has('phone_number')) {
                $user->phone_number = $request->phone_number;
            }

            if ($request->filled('password')) {
                if (!Hash::check($request->old_password, $user->password)) {
                    return response()->json(['old_password' => 'Mật khẩu cũ không đúng'], 400);
                }
                
                $user->password = Hash::make($request->password);
            }
            
            $user->save();

            return response()->json($user);
        } catch (Exception $ex) {
            return ApiUserExceptionHandler::handle($ex);
        }
    }
}
