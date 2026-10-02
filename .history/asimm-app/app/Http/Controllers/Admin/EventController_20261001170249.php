<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

Class EventController extends Controller
{
    public function index()
    {
    $evenements = Event::With('creator')
        ->orderBy('start_date', 'desc')
        -> paginate(15);
    return view('admin.events.index', compact('evenements'));
    }

    public function create()
    {
        $even
    }
}
