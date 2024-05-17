<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    //

    public function showByPeopleId($people_id)
{
    // Obtener los carros asociados a la persona
    $cars = Car::whereHas('person', function ($query) use ($people_id) {
        $query->where('id', $people_id);
    })->get();

    // Verificar si se encontraron carros
    if ($cars->isEmpty()) {
        $data = [
            "message" => "No se encontraron carros para la persona con ID $people_id",
            "status" => 404,
        ];
        return response()->json($data, 404);
    }

    // Devolver los carros encontrados
    $data = [
        "message" => "Listado de carros para la persona con ID $people_id",
        "data" => $cars,
        "status" => 200,
    ];
    return response()->json($data, 200);
}

public function show($id)
    {
        $car = Car::find($id);
        if (!$car) {
            $data = [
                "message" => "No se encontró el carro con ese ID",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            "message" => "Carro encontrado",
            "data" => $car,
            "status" => 200,
        ];
        return response()->json($data, 200);
    }

    public function index()
    {
        $cars = Car::all();

        $data = [
            "message"=> "Listado de carros",
            "data" => $cars,
            "status" => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // Obtener la persona asociada
        $person = People::find($request->input('people_id'));

        $validator = Validator::make($request->all(), [
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required',
            'people_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validación de los datos",
                "errors" => $validator->errors(),
                "status" => 400,
            ];
            return response()->json($data, 400);
        }

        if (!$person) {
            $data = [
                "message" => "Persona no encontrada",
                "status" => 404
            ];
            return response()->json($data, 404);
        }

        // Crear una nueva instancia de Car
        $car = Car::create([
            "brand" => $request->brand,
            "model" => $request->model,
            "year" => $request->year,
            "people_id" => $person->id
        ]);

        // Guardar la instancia de Car
        if (!$car) {
            $data = [
                "message" => "Error al crear el carro",
                "status" => 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            "message" => "Carro creado correctamente",
            "data" => $car,
            "status" => 201,
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
{
    $car = Car::find($id);
    if (!$car) {
        $data = [
            "message" => "No se encontró el carro a actualizar",
            "status" => 404,
        ];
        return response()->json($data, 404);
    }

    $validator = Validator::make($request->all(), [
        'brand' => 'required',
        'model' => 'required',
        'year' => 'required',
        'people_id' => 'required',
    ]);

    if ($validator->fails()) {
        $data = [
            "message" => "Error en la validación de los datos",
            "errors" => $validator->errors(),
            "status" => 400,
        ];
        return response()->json($data, 400);
    }

    // Obtener la persona asociada
    $person = People::find($request->input('people_id'));

    if (!$person) {
        $data = [
            "message" => "Persona no encontrada",
            "status" => 404
        ];
        return response()->json($data, 404);
    }

    // Actualizar los atributos del carro
    $car->brand = $request->brand;
    $car->model = $request->model;
    $car->year = $request->year;
    $car->people_id = $person->id;

    // Guardar los cambios en el carro
    if (!$car->save()) {
        $data = [
            "message" => "Error al actualizar el carro",
            "status" => 500,
        ];
        return response()->json($data, 500);
    }

    $data = [
        "message" => "Carro actualizado correctamente",
        "data" => $car,
        "status" => 200,
    ];

    return response()->json($data, 200);
}

    public function destroy($id)
    {
        $car = Car::find($id);
        if (!$car) {
            $data = [
                "message" => "No se encontró el carro a eliminar",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $car->delete();
        $data = [
            "message" => "Carro eliminado",
            "status" => 200,
        ];
        return response()->json($data, 200);

    }
}
