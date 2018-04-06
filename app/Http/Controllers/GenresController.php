<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use App\BookGenre;

class GenresController extends Controller
{
    /**
     * Показать все жанры
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::get();
        return view('books.genres.index', ['genres'=>$genres]);
    }
    /**
     * создать новый жанр
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:150|unique:genres'
            ],
            ['name.unique'=>'Такой жанр уже существует']
        );
        $genreName = $request->name;
        Genre::create(['name'=>$genreName]);
        return redirect('/admin/books/genres');
    }

    /**
     * Перезаписать имя жанра
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:150|unique:genres'
            ],
            ['name.unique'=>'Такой жанр уже существует']
        );
        $genreNew = $request->all();
        unset($genreNew['id'], $genreNew['_token']);
        Genre::find($id)->update($genreNew);
        return redirect()->route('genresAdmin');
    }

    /**
     * Удалить жанр
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BookGenre::where('genre_id', $id)->delete();
        Genre::destroy($id);
        return redirect('/admin/books/genres');
    }
}
