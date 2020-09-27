<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function create(Request $request)
    {
        try {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->errors(),
                ], 400);
            }

            $user = \App\Models\User::create($request->only('name', 'email'));

            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function fetchAll()
    {
        try {
            $users = \App\Models\User::all();
            return response()->json([
                'success' => true,
                'users' => $users,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function fetch($id)
    {
        try {
            $user = \App\Models\User::where('id', $id)->first();
            if (!$user) {
                throw new \Exception('The user was not found');
            }
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = \App\Models\User::find($id);
            if (!$user) {
                throw new \Exception('The user was not found');
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users,email,' . $user->id,
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->errors(),
                ], 400);
            }

            $updated = \App\Models\User::where('id', $id)->update($request->only('name', 'email'));

            return response()->json([
                'success' => true,
                'updated' => $updated,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $user = \App\Models\User::find($id);
            if (!$user) {
                throw new \Exception('The user was not found');
            }

            $deleted = \App\Models\User::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'deleted' => $deleted,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
