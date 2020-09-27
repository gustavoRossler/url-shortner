<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlShortnerController extends Controller
{

    public function create(Request $request)
    {
        try {
            $validator = \Validator::make(
                $request->all(),
                [
                    'url' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->errors(),
                ], 400);
            }

            $code = uniqid();

            $urlShort = \App\Models\UrlShort::create([
                'original' => $request->url,
                'code' => $code,
                'short' => env('APP_URL') . '/' . $code,
                'clicks' => 0
            ]);

            return response()->json([
                'success' => true,
                'url' => $urlShort,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function fetch($code)
    {
        try {
            $urlShort = \App\Models\UrlShort::where('code', $code)->first();
            if (!$urlShort) {
                throw new \Exception('The informed URL was not found');
            }
            return response()->json([
                'success' => true,
                'url' => $urlShort,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $code)
    {
        try {
            $urlShort = \App\Models\UrlShort::where('code', $code)->first();
            if (!$urlShort) {
                throw new \Exception('The informed URL was not found');
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'url' => 'required|string',
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validator->errors(),
                ], 400);
            }

            $updated = \App\Models\UrlShort::where('code', $code)->update([
                'original' => $request->url
            ]);

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

    public function delete($code)
    {
        try {
            $urlShort = \App\Models\UrlShort::where('code', $code)->first();
            if (!$urlShort) {
                throw new \Exception('The informed URL was not found');
            }

            $deleted = \App\Models\UrlShort::where('code', $code)->delete();

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
