<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Utils\Toast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        return view('backend.pages.dashboard');
    }

    public function toastDemo(Request $request): RedirectResponse
    {
        $message = $request->get('message', 'Toast di esempio');
        $type = $request->get('type', 'info');

        Toast::show($type, $message);

        return redirect()->back();
    }

    public function alertDemo(Request $request): RedirectResponse
    {
        if ($request->get('validate', false)) {
            $request->validate([
                'random' => 'required',
            ]);
        }

        $message = $request->get('message', 'Alert di esempio');
        $type = $request->get('type', 'warning');

        Session::flash($type, $message);

        return redirect()->back();
    }
}
