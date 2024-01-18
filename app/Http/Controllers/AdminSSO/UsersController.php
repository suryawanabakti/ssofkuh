<?php

namespace App\Http\Controllers\AdminSSO;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::role(['user'])->get();
        return view('adminsso.users.index', compact('users'));
    }

    public function create()
    {
        return view('adminsso.users.create');
    }

    public function store(Request $request)
    {
        $valData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:5'
        ]);

        $valData['password'] = bcrypt($request->password);
        $user = User::create($valData);
        $user->assignRole("user");
        return redirect('/users')->with('success', 'Berhasil tambah user');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users')->with('success', 'Berhasil hapus user');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['file', 'mimes:xlsx', 'required'],
        ]);
        Excel::import(new UsersImport, $request->file('file'));
        return redirect('/dashboard')->with('success', 'All good!');
    }
}
