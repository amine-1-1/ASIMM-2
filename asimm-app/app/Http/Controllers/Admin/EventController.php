<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Liste admin (GET /admin/events) ou page publique (GET /calendrier.html) : même méthode, deux routes
    public function index(Request $request)
    {
        if ($request->routeIs('events.calendar')) {
            return $this->calendar($request);
        }

        $evenements = Event::with('creator')->orderBy('start_date', 'desc')->paginate(15);

        return view('admin.events.index', compact('evenements'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        Event::create($this->donneesValidees($request) + ['created_by' => auth()->id()]);

        return redirect()->route('admin.events.create')->with('success', 'Événement créé avec succès.');
    }

    public function show($id)
    {
        $evenement = Event::with('creator')->findOrFail($id);

        return view('admin.events.show', compact('evenement'));
    }

    public function edit($id)
    {
        $evenement = Event::findOrFail($id);

        return view('admin.events.edit', compact('evenement'));
    }

    public function update(Request $request, $id)
    {
        Event::findOrFail($id)->update($this->donneesValidees($request));

        return redirect()->route('admin.events.index')->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();

        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé avec succès.');
    }

    // Règles du formulaire, communes à la création et à la modification
    private function donneesValidees(Request $request): array
    {
        $donnees = $request->validate([
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

        // Case à cocher : absente du formulaire quand elle est décochée
        $donnees['is_published'] = $request->boolean('is_published');

        return $donnees;
    }

    private function calendar(Request $request)
    {
        $evenements = Event::where('is_published', true)->orderBy('start_date')->get();
        $jourChoisi = $request->date('jour');
        $calendrier = $this->calendrier($evenements, $jourChoisi);

        if ($jourChoisi) {
            $evenements = $evenements->filter(fn ($e) => $e->start_date->isSameDay($jourChoisi));
        }

        return view('events.calendar', compact('evenements', 'calendrier', 'jourChoisi'));
    }

    private function calendrier($evenements, $jourChoisi = null): array
    {
        $mois = today();

        foreach ($evenements as $evenement) {
            if ($evenement->end_date >= today()) {
                $mois = $evenement->start_date;
                break;
            }
        }

        if ($jourChoisi) {
            $mois = $jourChoisi;
        }

        $mois = $mois->copy()->startOfMonth();

        $premierJour = $mois->copy()->startOfWeek();
        $dernierJour = $mois->copy()->endOfMonth()->endOfWeek();

        $jours = [];
        $jour = $premierJour;

        while ($jour <= $dernierJour) {
            $evenementDuJour = null;

            foreach ($evenements as $evenement) {
                if ($evenement->start_date->isSameDay($jour)) {
                    $evenementDuJour = $evenement;
                    break;
                }
            }

            $jours[] = [$jour->copy(), $evenementDuJour];
            $jour->addDay();
        }

        return ['mois' => $mois, 'jours' => $jours];
    }
}
