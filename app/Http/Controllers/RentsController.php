<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Http\Resources\RentsResource;
use App\Models\Book;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return RentsResource::collection(Rent::paginate());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRentRequest $request)
    {

        // CHECK IF THE USER HAS BOOKS OVERDUE
        $user = Auth::user();
        if ($user->has('rents')) {

            $num_rented_books = $user->rents->count();

            $hasRented = 'Has rented books';
            $user->rents->has('returned_date')
                ? $booksPending = 'don´t owe any books'
                : $booksPending = 'has books to return';

            // see if the user has books which to_date has expired
            $overdueBooks = $user->rents()
                ->whereDate('to_date', '<', now())
                ->where('returned_date', null)
                ->get();

            $overdueBooks = $overdueBooks->count();
        } else
            $hasRented = 'Dont have rented books';

        if ($overdueBooks > 0) {
            return response()->json([
                'error' => 'the user has books overdue, connot rent a book',
                'rented_to_date' => $num_rented_books,
                'Rent status' => $hasRented,
                'Books_owed' => $booksPending,
                'books_owes' => $overdueBooks,
                'user' => Auth::user(),
            ], 403);
        };

        // CHECK IF THE BOOK IS AVAILABLE FOR RENTING

        $bookId = $request->validated()['book_id'];
        $book = Book::find($bookId);

        if (! Book::where('id', $bookId)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->first()) {

            return response()->json([
                'error' => 'Book is not available of not in stock'
            ], 404);
        };

        $validateData = $request->validated();
        $validateData['user_id'] = Auth::id();

        $rent = Rent::create($validateData);

        return response()->json([
            'status' => 'success',
            'attributes' => new RentsResource($rent),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rent $rent)
    {
        return new RentsResource($rent);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
