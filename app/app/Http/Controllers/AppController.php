<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index($code = '')
    {
        try {
            if (!$code) {
                return view('error', [
                    'message' => 'É necessário informar um código de URL válido.'
                ]);
            }
            $urlShort = \App\Models\UrlShort::where('code', $code)->first();
            if (!$urlShort) {
                return view('error', [
                    'message' => 'A URL informada é inválida.'
                ]);
            }

            $urlShort->clicks = $urlShort->clicks + 1;
            $urlShort->save();

            return redirect($urlShort->original);
        } catch (\Exception $e) {
            if (!$urlShort) {
                return view('error', [
                    'message' => 'Encontramos um erro: ' . $e->getMessage()
                ]);
            }
        }
    }
}
