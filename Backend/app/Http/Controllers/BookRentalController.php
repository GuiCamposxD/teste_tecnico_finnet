<?php

namespace App\Http\Controllers;

use App\Models\BookRental;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookRentalController extends Controller
{
	public function create(Request $request) {
		$validator = Validator::make($request->all(), [
			'book_id' => 'required|exists:book,id',
			'people_id' => 'required|exists:people,id',
			'delivery_date' => 'required',
		]);

		if ($validator->fails()) return response()->json($validator->errors(), 422);

		$bookRental = BookRental::create($validator->validate());

		$book = Book::find($request->book_id);

		if ($book) $book->decrement('quantity');

		return $bookRental;
	}

	public function list() {
		return Book::with(['people' => function ($query) {
			$query->withPivot('id', 'delivery_date', 'created_at');
		}])
			->get();
	}

	public function getById(Request $request) {
		return Book::with(['people' => function ($query) use ($request){
			$query
				->withPivot('id')
				->wherePivot('people_id', $request->query('id'));
		}])
			->get();
	}

	public function delete(Request $request) {
		$bookRental = BookRental::destroy($request->id);

		$book = Book::find($request->book_id);

		if ($book) $book->increment('quantity');

		return $bookRental;
	}
}
