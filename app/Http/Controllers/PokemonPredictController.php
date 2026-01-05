<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PokemonPrediction;
use GuzzleHttp\Client;

class PokemonPredictController extends Controller
{
    public function predict(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:5120'
        ]);

        $path = $request->file('file')->store('predictions', 'public');

        $client = new Client();

        try {
            $response = $client->request('POST', env('FLASK_API_URL') . '/predict', [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen(storage_path("app/public/$path"), 'r'),
                        'filename' => basename($path)
                    ]
                ],
                'timeout' => 60
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Flask server unreachable',
                'message' => $e->getMessage()
            ], 500);
        }

        $body = $response->getBody()->getContents();
        $data = json_decode($body, true);

        PokemonPrediction::create([
            'image' => $path,
            'label' => $data['prediction'] ?? 'unknown',
            'confidence' => $data['predictions'][0]['confidence'] ?? 0
        ]);

        return response()->json($data);
    }
}
