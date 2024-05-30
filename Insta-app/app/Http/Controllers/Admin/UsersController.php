<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        // withTrashed() -Include the soft deleted records in a query's result
        $all_users = $this->user->withTrashed()->latest()->paginate(5);

        return view('admin.users.index')
                ->with('all_users', $all_users);
    }

    public function deactivate($id){
        $this->user->destroy($id);

        return redirect()->back();
    }

    public function activate($id){
        //onlyTrashed() -retrieves soft deleted recordds only.
        //restore() -This will "un-delete" a soft deleted model. also this will set the "deleted_at" colum to null
        $this->user->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }

    public function search(Request $request)
    {
        $users = $this->user->where('name', 'like', '%' . $request->search . '%')->get();

        return view('admin.users.search')
                ->with('users', $users)
                ->with('search', $request->search);
    }
}
