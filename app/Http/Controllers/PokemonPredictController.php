<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Input;
use App\Models\PokemonPrediction;
use Illuminate\Support\Facades\Log;

class PokemonPredictController extends Controller
{
    public function predict(Request $request)
    {

        $request->validate([
            'input_id' => 'required|exists:inputs,id',
        ]);

        $input = Input::findOrFail($request->input_id);

        $imagePath = storage_path('app/public/' . $input->image);

        if (!file_exists($imagePath)) {
            return response()->json([
                'message' => 'Image file not found'
            ], 404);
        }

        // 3. Kirim gambar ke Flask API
        $client = new Client();

        try {
            $response = $client->post(
                rtrim(env('FLASK_API_URL'), '/') . '/predict',
                [
                    'multipart' => [
                        [
                            'name'     => 'file',
                            'contents' => fopen($imagePath, 'r'),
                            'filename' => basename($imagePath),
                        ],
                    ],
                    'timeout' => 60,
                ]
            );
        } catch (\Throwable $e) {
            Log::error('Flask API Error', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Flask server unreachable'
            ], 500);
        }

        // 4. Decode response Flask
        $data = json_decode($response->getBody(), true);

        $label = $data['prediction'] ?? 'unknown';
        $confidence = $data['predictions'][0]['confidence'] ?? 0;

        // 5. Simpan prediction
        $prediction = PokemonPrediction::create([
            'input_id'   => $input->id,
            'label'      => $label,
            'confidence' => $confidence,
        ]);

        // 6. Response
        return response()->json([
            'input' => [
                'id' => $input->id,
                'image' => $input->image,
            ],
            'prediction' => $prediction,
            'raw_response' => $data
        ]);
    }
}
