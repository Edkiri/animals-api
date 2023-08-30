<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

use App\Models\Animal;

class AnimalController extends Controller
{
    public function create(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'name' => ['required', 'string', 'min:2', 'unique:animals,name'],
                'species' => ['required', 'string', 'min:2'],
                'gender' => ['required', 'in:male,female'],
                'age' => ['nullable', 'numeric', 'gt:0'],
                'weight' => ['nullable', 'numeric', 'gt:0'],
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
            }

            $validData = $validator->validated();

            $newAnimalData = [
                'name' => $validData['name'],
                'species' => $validData['species'],
                'gender' => $validData['gender'],
            ];

            if (array_key_exists('age', $validData)) {
                $newAnimalData['age'] = $validData['age'];
            }

            if (array_key_exists('weight', $validData)) {
                $newAnimalData['weight'] = $validData['weight'];
            }

            $newAnimal = Animal::create($newAnimalData);

            return response()->json([
                'success' => true,
                'data' => [
                    'animal' => $newAnimal,
                ]
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating animal' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findAll()
    {
        try {
            $animals = Animal::get();

            return response()->json([
                'success' => true,
                'data' => [
                    'animals' => $animals,
                ]
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('Error getting animals' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
