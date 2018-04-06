<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Book;
use App\BookGenre;
use App\Genre;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Выводит страницу админа
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.index', ['user' =>$user]);
    }
    /**
     * Выводит форму сообщний
     *
     * @return \Illuminate\Http\Response
     */
    public function mailForm()
    {
        return view('emails.mail-form');
    }

}
