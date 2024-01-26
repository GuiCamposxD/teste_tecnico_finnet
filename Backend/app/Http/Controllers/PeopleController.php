<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeopleController extends Controller
{
    public function create(Request $request) {
      $validator = Validator::make($request->all(), [
        'address' => 'required',
        'age' => 'required|numeric',
        'cpf' => 'required',
        'gender' => 'required',
        'name' => 'required',
      ]);
  
      if ($validator->fails()) return response()->json($validator->errors(), 422);

      return People::create($validator->validate());
    }

    public function list() {
      return People::orderBy('name')
        ->get();
    }

    public function update(Request $request) {
      $validator = Validator::make($request->all(), [
        'address' => 'required',
        'age' => 'required|numeric',
        'gender' => 'required',
        'name' => 'required',
      ]);
  
      if ($validator->fails()) return response()->json($validator->errors(), 422);

      return People::where('id', $request->id)
        ->update($validator->validate());
    }

    public function delete(Request $request) {
      return People::destroy($request->id);
    }

    public function getById(Request $request) {
      return People::find($request->query('id'));
    }
}
