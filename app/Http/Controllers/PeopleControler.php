<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleControler extends Controller
{
    //


    public function index()
    {
        $people = People::all();

        $data = [
            "message"=> "Listado de peoples",
            "data" => $people,
            "status" => 200 
        ];  
        return response()->json($data, 200);

    }

    public function show($id)
    {
        $people = People::find($id);
        if (!$people) {
            $data = [
                "message" => "No se enocntró la people",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            "message" => "Usuario encontrado",
            "data" => $people,
            "status" => 200,
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:people",
            "password" => "required",
            'phone' => 'required',
            "language" => "required"
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validación de los datos",
                "errors" => $validator->errors(),
                "status" => 400,
            ];
            return response()->json($data, 400);
        }
        $people = People::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'language' => $request->language
        ]);
        if (!$people) {
            $data = [
                "message" => "Error al crear la people",
                "status" => 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            "message" => "people creada correctamente",
            "data" => $people,
            "status" => 201,
        ];

        return response()->json($data, 201);

    }

    public function update(Request $request, $id)
    {
        $people = People::find($id);
        if (!$people) {
            $data = [
                "message" => "No se enocntró la people",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:people",
            "password" => "required",
            'phone' => 'required',
            "language" => "required"
        ]);

        if ($validator->fails()) {
            $data = [
                "message" => "Error en la validación de los datos",
                "errors" => $validator->errors(),
                "status" => 400,
            ];
            return response()->json($data, 400);
        }
        $people->name = $request->name;
        $people->email = $request->email;
        $people->password = $request->password;
        $people->phone = $request->phone;
        $people->language = $request->language;
        $people->save();

        $data = [
            "message"=> "Usuario actualizado correctamente",
            "data" => $people,
            "status"=> 200,
        ];

        return response()->json($data, 200);

    }

    public function destroy($id)
    {
        $people = People::find($id);
        if (!$people) {
            $data = [
                "message" => "No se encontró la people",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $people->delete();
        $data = [
            "message" => "Usuario eliminado",
            "status" => 200,
        ];
        return response()->json($data, 200);

    }

}
