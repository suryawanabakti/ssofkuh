<?php

namespace App\Http\Controllers\AdminSSO;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::role(['user']);
        if ($request->search) {
            $users->where('name', 'LIKE', "%{$request->search}%")
                ->orWhere('username', 'LIKE', "%{$request->search}%");
        }
        $users = $users->paginate(10);
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

    public function edit(User $user)
    {
        return view('adminsso.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => "required|max:255",
            'username' => "required|regex:/^\S*$/u|unique:users,username," . $user->id,
        ]);

        if ($request->password) {
            $request->validate([
                'password' => 'confirmed|min:5',
            ]);
            $validatedData['password'] = bcrypt($request->password);
        }

        $user->update($validatedData);

        return redirect('/users')->with('success', 'Berhasil update user');
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
