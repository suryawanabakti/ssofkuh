<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;

class AppsController extends Controller
{
    public function index()
    {
        $apps = App::orderBy('created_at', 'desc')->get();
        return view('adminsso.apps.index', compact('apps'));
    }

    public function create()
    {
        return view('adminsso.apps.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'url' => 'required|url',
            'type_icon' => '',
            'icon' => ''
        ]);

        if ($request->type_icon === 'upload_img') {
            $request->validate([
                'icon' => 'image|mimes:png,jpg,jpeg,gif',
            ]);

            $validatedData['icon'] = $request->file('icon')->store('icon');
        }

        App::create($validatedData);

        return redirect('/apps')->with('success', 'Berhasil tambah aplikasi');
    }

    public function edit(App $app)
    {
        return view('adminsso.apps.edit', compact('app'));
    }

    public function update(Request $request, App $app)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'url' => 'required|url',
            'type_icon' => '',
            'icon' => ''
        ]);

        if ($request->type_icon === 'upload_img') {
            $request->validate([
                'icon' => 'image|mimes:png,jpg,jpeg,gif',
            ]);
            @unlink('storage/' . $app->icon);
            $validatedData['icon'] = $request->file('icon')->store('icon');
        }

        $app->update($validatedData);
        return redirect('/apps')->with('success', 'Berhasil edit aplikasi');
    }

    public function destroy(App $app)
    {
        @unlink('storage/' . $app->icon);
        $app->delete();
        return redirect('/apps')->with('success', 'Berhasil hapus aplikasi');
    }
}
