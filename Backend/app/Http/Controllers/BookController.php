<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
	public function create(Request $request) {
		$validator = Validator::make($request->all(), [
			'author' => 'required',
			'publisher' => 'required',
			'quantity' => 'required|numeric|min:0',
			'title' => 'required',
		]);

		if ($validator->fails()) return response()->json($validator->errors(), 422);

		return Book::create($validator->validated());
	}

	public function list() {
		return Book::orderBy('title')
			->get();
	}

	public function update(Request $request) {
		$validator = Validator::make($request->all(), [
			'author' => 'required',
			'publisher' => 'required',
			'quantity' => 'required|numeric|min:0',
			'title' => 'required',
		]);

		if ($validator->fails()) return response()->json($validator->errors(), 422);

		return Book::where('id', $request->id)
			->update($validator->validated());
	}

	public function delete(Request $request) {
		$validator = Validator::make($request->all(), [
			'id' => 'required',
		]);

		if ($validator->fails()) return response()->json($validator->errors(), 422);

		return Book::destroy($validator->validated());
	}

	public function getById(Request $request) {
		return Book::find($request->query('id'));
	}

	public function listAvailable() {
		return Book::where('quantity', '>', 0)
			->orderBy('title')
			->get();
	}
}
