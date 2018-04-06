<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\BookGenre;
use App\Genre;
use App\BookUser;
use App\User;

class BookController extends Controller
{
    /**
     * Проверяет был ли выполнен поиск и ели да выводит найденные книги по названию и автору
     * В противном отображает список всех книг
     *
     * @return шаблон library
     */
    public function index(Request $request)
    {
        if(isset($request->search)){
            $value = '%'.$request->search.'%';
            $books = Book::orderBy('title_book')->where('title_book', 'LIKE', $value)
                ->orWhere('author', 'LIKE', $value)->paginate(12);
        } else {
            $books = Book::orderBy('title_book')->paginate(12);
        }
        $genres = BookGenre::all()->groupBy('book_id');
        $usedGenres = BookGenre::all()->keyBy('genre_id');
        $allgenres = Genre::all()->keyBy('id');
        return view('library', ['books'=>$books, 'genres'=>$genres, 'usedGenres'=>$usedGenres, 'allGenres'=>$allgenres]);
    }
    /**
     * Показывает книги по 1 жанру
     *
     * @return \Illuminate\Http\Response
     */
    public function groupByGenre($genreId)
    {
        $booksId = BookGenre::where('genre_id', $genreId)->pluck('book_id');
        $books = Book::whereIn('id', $booksId)
            ->orderBy('title_book')
            ->paginate(12);
        $genres = BookGenre::all()->groupBy('book_id');
        $usedGenres = BookGenre::all()->keyBy('genre_id');
        $allGenres = Genre::all()->keyBy('id');
        return view('library', ['books'=>$books, 'genres'=>$genres, 'usedGenres'=>$usedGenres,'allGenres'=>$allGenres]);
    }
    /**
     * Передаёт список книг отсортированных по $column
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin($column, $order)
    {
        $books = Book::orderBy($column, $order)
            ->paginate(20);
        $genres = BookGenre::all()->groupBy('book_id');
        $taken = BookUser::all()->groupBy('book_id');
        $allGenres = Genre::all()->keyBy('id');
        if($order == 'desc')
            $order = 'asc';
        else
            $order = 'desc';
        return view('books.admin', ['books'=>$books, 'genres'=>$genres, 'order'=>$order, 'taken'=>$taken,'allGenres'=>$allGenres]);
    }
    /**
     * Передаёт книги с совпадениями в полях title_book, author, inventory_number со значнием $request->search
     *
     * @return \Illuminate\Http\Response
     */
    public function serchIndex(Request $request)
    {
        $genres = BookGenre::all()->groupBy('book_id');
        $allGenres = Genre::all()->keyBy('id');
        $value = '%'.$request->search.'%';
        $books = Book::where('title_book', 'LIKE', $value)
            ->orWhere('author', 'LIKE', $value)
            ->orWhere('inventory_number', 'LIKE', $value)
            ->orderBy('title_book', 'asc')
            ->paginate(20);
        $taken = BookUser::all()->groupBy('book_id');
        return view('books.admin', ['books'=>$books, 'genres'=>$genres, 'order'=>'asc', 'taken'=>$taken,'allGenres'=>$allGenres ]);
    }
    /**
     * Показать форму для создания новой книги
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allGenres = Genre::get();
        return view('books.form', ['allGenres'=>$allGenres]);
    }

    /**
     * Сохранить книгу со значениями из формы
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title_book' => 'required|max:150',
            'author' => 'required|max:100'
        ]);
        $book = $request->all();
        if (isset($request->image)){
            $img = $request->image->store('book_images');
            $img = 'storage/app/'.$img;
            $book['image'] = $img;
        }
        $genres = $request->genres;
        unset($book['_token'],$book['id'],$book['genres']);
        $createdBook =  Book::create($book);
        $id = $createdBook['id'];
        $data = [];
        if ($genres!='')
        foreach($genres as $val){
            if ($val != 'no'){
                $data[] = ['genre_id' => $val, 'book_id' => $id];
            };
        };
        BookGenre::insert($data);
        $allGenres = Genre::get();
        return view('books.form', ['allGenres'=>$allGenres]);
    }

    /**
     * Показать одну книгу
     *
     * @param  int  $id номер книги
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $role = (isset($user))? $user->role : '' ;
        if ($role == 'admin'){
            $taken = BookUser::where('book_id', $id)->get();
            $arrIdTook = [];
            $arrIdDetained = [];
            foreach($taken as $onetaken){
                if(time()>strtotime($onetaken->return_date)){
                    $arrIdDetained[] = $onetaken->user_id;
                }else{
                    $arrIdTook[] = $onetaken->user_id;
                }
            }
            $usersWhoTook = User::whereIn('id', $arrIdTook)->get();
            $usersWhoDetained = User::whereIn('id', $arrIdDetained)->get();
        } else {
            $usersWhoTook = '';
            $usersWhoDetained = '';
            $taken ='';
        }
        $allGenres = Genre::all()->keyBy('id');
        $genres = BookGenre::where('book_id', $id)->get();
        $book = Book::where('id', $id)->first();
        return view('books.book', ['book'=>$book, 'genres'=>$genres, 'role'=>$role, 'taken'=>$taken,
            'usersTook'=>$usersWhoTook, 'usersDetained'=>$usersWhoDetained, 'allGenres'=>$allGenres]);
    }

    /**
     * Перенаправляет на форму редактирования книги
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allGenres = Genre::all()->keyBy('id');
        $bookGenres = BookGenre::where('book_id', $id)->get();
        $genresId = [];
        foreach($bookGenres as $genre){$genresId[]=$genre->genre_id;}
        $book = Book::where('id', $id)->first();
        return view('books.form', ['book' => $book, 'allGenres'=>$allGenres, 'genresId'=>$genresId]);
    }

    /**
     * Обновление книги с id $id значениями из формы
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title_book' => 'required|max:200',
            'author' => 'required|max:60'
        ]);
        $book = $request->all();
        if (isset($request->image)){
            $img = $request->image->store('book_images');
            $img = 'storage/app/'.$img;
            $book['image'] = $img;
        }
        if($request->defaultImg == 'yes'){
            $book['image'] = 'storage/app/public/book_images/cover.png';
        }
        $genres = $request->genres;
        $data = [];
        if ($genres!='')
            foreach($genres as $val){
                if ($val != 'no'){
                    $data[] = ['genre_id' => $val, 'book_id' => $id];
                };
            };
        BookGenre::where('book_id', $id)->delete();
        BookGenre::insert($data);
        unset($book['_token'],$book['id'],$book['genres'],$book['defaultImg']);
        Book::find($id)->update($book);
        return redirect()->back();
    }

    /**
     * Удаление книги по id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, ['book_id'=>'unique:books_users'],
            ['book_id.unique'=>'Нельзя удалить книгу, если не все возвращены']);
        BookGenre::where('book_id', $id)->delete();
        Book::destroy($id);
        return redirect()->action('BookController@indexAdmin', ['column' => 'title_book', 'order'=>'asc']);
    }
}
