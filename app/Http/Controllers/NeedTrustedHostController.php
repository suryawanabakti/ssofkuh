<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\NeedTrustedHost;

class NeedTrustedHostController extends Controller
{
    public function index(App $app)
    {
        $needTrustedHost =  NeedTrustedHost::with('user')->where('app_id', $app->id)->get();
        return view('adminsso.apps.need-trusted-host', compact('needTrustedHost', 'app'));
    }

    public function destroy(NeedTrustedHost $needTrustedHost)
    {
        $needTrustedHost->delete();
        return back()->with("success", "berhasil hapus tautan user");
    }
}
