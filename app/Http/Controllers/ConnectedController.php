<?php

namespace App\Http\Controllers;

use App\Models\NeedTrustedHost;

class ConnectedController extends Controller
{
    public function index()
    {
        $needTrustedHost = NeedTrustedHost::where('user_id', auth()->id())->get();

        return view('connected', compact('needTrustedHost'));
    }

    public function destroy($id)
    {
        NeedTrustedHost::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus');
    }
}
