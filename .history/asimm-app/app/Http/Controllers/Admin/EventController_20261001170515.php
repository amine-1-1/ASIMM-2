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
        $evenement = null;
        return view('admin.events.create', compact('evenement'));
    }

    public function store (Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'schedule' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string',
            'link_url' => 'nullable|url|max:255',
            'link_label' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);
        


    }
}
