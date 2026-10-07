<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('role');
        $evenements = Event::with('creator')
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('dashboard', compact('user', 'evenements'));
    }
}