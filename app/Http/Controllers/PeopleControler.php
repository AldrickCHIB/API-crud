<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleControler extends Controller
{
    //


    public function index()
    {
        $person = Person::all();
        if ($person->isEmpty()) {
            $data = [
                "message" => "No se encontraron personas",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            "message"=> "Listado de personas",
            "data" => $person,
            "status" => 200 
        ];  
        return response()->json($data, 200);

    }

    public function show($id)
    {
        $person = Person::find($id);
        if (!$person) {
            $data = [
                "message" => "No se enocntró la persona",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $data = [
            "message" => "Usuario encontrado",
            "data" => $person,
            "status" => 404,
        ];
        return response()->json($data, 404);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:person",
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
        $person = Person::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'language' => $request->language
        ]);
        if (!$person) {
            $data = [
                "message" => "Error al crear la persona",
                "status" => 500,
            ];
            return response()->json($data, 500);
        }

        $data = [
            "message" => "Persona creada correctamente",
            "data" => $person,
            "status" => 201,
        ];

        return response()->json($data, 201);

    }

    public function update(Request $request, $id)
    {
        $person = Person::find($id);
        if (!$person) {
            $data = [
                "message" => "No se enocntró la persona",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:person",
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
        $person->name = $request->name;
        $person->email = $request->email;
        $person->password = $request->password;
        $person->phone = $request->phone;
        $person->language = $request->language;
        $person->save();

        $data = [
            "message"=> "Usuario actualizado correctamente",
            "data" => $person,
            "status"=> 200,
        ];

        return response()->json($data, 200);

    }

    public function destroy($id)
    {
        $person = Person::find($id);
        if (!$person) {
            $data = [
                "message" => "No se enocntró la persona",
                "status" => 404,
            ];
            return response()->json($data, 404);
        }

        $person->delete();
        $data = [
            "message" => "Usuario eliminado",
            "status" => 200,
        ];
        return response()->json($data, 200);

    }

}
