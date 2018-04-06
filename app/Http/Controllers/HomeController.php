<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\BookUser;
use App\Book;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Показать страницу профиля, авторизованного пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $usersBooks = BookUser::where('user_id', $user->id)->get();
        $bookId = [];
        foreach ($usersBooks as $book){
            $bookId[] = $book->book_id;
        }
        $books = Book::all()->keyBy('id')->whereIn('id', $bookId);
        return view('home', ['user' => $user, 'usersBooks'=>$usersBooks, 'books'=>$books]);

    }
    public function admin()
    {
        return redirect('/admin');
    }
}
