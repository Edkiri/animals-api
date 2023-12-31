<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Animal;

class AnimalController extends Controller
{
    public function create(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'name' => ['required', 'string', 'min:4'],
                'species' => ['required', 'string', 'min:4'],
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
            $animals = Animal::orderByDesc('id')->get();

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

    public function delete($id)
    {
        try {
            $animal = Animal::findOrFail($id);
            $animal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Animal deleted successfully',
            ], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Animal not found',
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            Log::error('Error deleting animal: ' . $th->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error deleting animal',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
