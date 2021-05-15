<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $userID = $request->query('uid');

        if (!isset($userID)) {
            return;
        }

        return response()->json(User::findOrFail($userID));
        return User::findOrFail($userID);
    }

    public function update(Request $request)
    {
        //
        $toUpdate = json_decode($request->getContent(), true);
        $user = User::find($request->query('uid'));
        $user->update(array_merge($toUpdate, ['password' => $user->password]));

        return response()->json(['data' => $user, 'message' => 'Successfully updated!', 'status' => 'Success']);
    }

    public function destroy($id)
    {
        //
    }
}
