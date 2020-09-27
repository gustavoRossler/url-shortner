<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlShortnerController extends Controller
{
    //
    public function create(Request $request)
    {
        try {
            $url = $request->url;
            $newId = uniqid();
            return response()->json([
                'success' => true,
                'data' => [
                    'shortenedUrl' => $newId
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
