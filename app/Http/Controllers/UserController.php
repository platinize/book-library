<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\BookGenre;
use App\BookUser;
use App\Genre;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role)
    {
        $users = User::where('role', '=', $role)
            ->orderBy('id', 'desc')
            ->paginate(10);
        $books = BookUser::get();
        $booksArr = [];
        $overdue = [];
        foreach($books as $book){
            $booksArr[$book->user_id][] = $book->book_id;
            if(time()> strtotime($book->return_date))
            $overdue[$book->user_id][] = $book->book_id;
        }
        return view('users.index', ['users'=>$users, 'books'=>$booksArr, 'overdue'=>$overdue, 'role'=>$role]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function serchUser(Request $request, $role)
    {
        $value = '%'.$request->search.'%';
        $users = User::where('phone', 'LIKE', $value)
            ->orWhere('name', 'LIKE', $value)
            ->orWhere('email', 'LIKE', $value)
            ->orWhere('card_number', 'LIKE', $value)
            ->paginate(20);
        $books = BookUser::get();
        $booksArr = [];
        $overdue = [];
        foreach($books as $book){
            $booksArr[$book->user_id][] = $book->book_id;
            if(time()> strtotime($book->return_date))
                $overdue[$book->user_id][] = $book->book_id;
        }
        return view('users.index', ['users'=>$users, 'books'=>$booksArr, 'overdue'=>$overdue, 'role'=>$role]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.form');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:250',
            'address' => 'required|max:250',
            'role' => 'required'
        ]);
        $user = $request->all();
        if (isset($request->photo)){
            $img = $request->photo->store('user_photo');
            $user['photo'] = 'storage/app/'.$img;
        }
        $user['password'] = 'default';
        $last = User::orderBy('id', 'desc')->first();
        $user['card_number'] = strtoupper(str_random(2)).rand(100000,999999).$last->id;
        $user['email'] = ($user['email'] == '')? 'default'.$last->id : $user['email'];
        unset($user['_token'],$user['id']);
        User::insert($user);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $role = $user->role;
        $usersBooks = BookUser::where('user_id', $id)->get();
        $bookId = [];
        $booksInfo = [];
        foreach ($usersBooks as $book){
            $bookId[] = $book->book_id;
            $booksInfo[$book->book_id] = ['return_date'=>$book->return_date, 'id'=>$book->id];
        }
        $books = Book::whereIn('id', $bookId)->get();
        $user = User::where('id', $id)->first();
        return view('users.profile', ['user' => $user, 'usersBooks'=>$usersBooks,
            'books'=>$books, 'booksInfo'=>$booksInfo, 'role'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('users.form', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|max:300',
            'role' => 'required',
        ]);
        $user = $request->all();
        if (isset($request->photo)){
            $img = $request->photo->store('user_photo');
            $user['photo'] = 'storage/app/'.$img;
        };
        if($request->defaultPhoto == 'yes'){
            $user['photo'] = 'storage/app/user_photo/photo.jpg';
        };
        unset($user['_token'],$user['id'],$user['defaultPhoto']);
        User::find($id)->update($user);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!is_numeric($id)) return false;
        User::destroy($id);
        return redirect()->back();
    }
    /**
     * Установить фото на профиль
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePhoto(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|image'
        ]);
        $img = 'storage/app/'.$request->photo->store('user_photo');
        $user = Auth::user();
        User::find($user->id)->update(['photo'=>$img]);
        return redirect()->back();
    }
    /**
     * Сбросить фотографию профиля до дефолтной
     *
     * @return \Illuminate\Http\Response
     */
    public function defaultPhoto()
    {
        $user = Auth::user();
        User::find($user->id)->update(['photo'=>'storage/app/user_photo/photo.jpg']);
        return redirect()->back();
    }
}
