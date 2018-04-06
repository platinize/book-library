<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\BookGenre;
use App\BookUser;
use App\Genre;
use App\User;

class BookUserController extends Controller
{
    /**
     * Список взятых книг пользователями
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taken = BookUser::paginate(15);
        $users = User::all()->keyBy('id');
        $books = Book::all()->keyBy('id');
        return view('books.takenBooks', ['taken'=>$taken,'users'=>$users,'books'=>$books]);
    }

    /**
     * Страница добавления книг пользователю с id $userId
     * @userId id пользователя
     * @return \Illuminate\Http\Response
     */
    public function create($userId)
    {
        $books = Book::paginate(15);
        return view('books.createBookUser', ['books'=>$books,'userId'=>$userId]);
    }
    /**
     * поиск книги по title_book, author, inventory_number на стринице выдачи книг
     *
     * @return \Illuminate\Http\Response
     */
    public function createSearch(Request $request, $userId)
    {
        $value = '%'.$request->search.'%';
        $books = Book::where('title_book', 'LIKE', $value)
            ->orWhere('author', 'LIKE', $value)
            ->orWhere('inventory_number', 'LIKE', $value)
            ->orderBy('title_book', 'asc')
            ->paginate(15);
        return view('books.createBookUser', ['books'=>$books,'userId'=>$userId]);
    }

    /**
     * Создание записи о взятии книги
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'book_id' => 'required',
            'user_id' => 'required',
            'return_date' => 'required',
        ]);
        $took = $request->all();
        BookUser::create($took);
        return redirect()->back();
    }

    /**
     * Удаление записи о взятии книги
     *
     * @param  int  $id - id записи
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) return false;
        BookUser::destroy($id);
        return redirect()->back();
    }
}
