<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administration — Événements
            </h2>
            <a href="{{ route('admin.events.create') }}" class="asimm-btn-new">
                <i class="bi bi-plus-lg"></i> Nouvel événement
            </a>
        </div>
    </x-slot>

    @php
        // Mois en français : abrégés pour le bloc orange, complets pour le texte
        $moisCourts = ['JANV', 'FÉV', 'MARS', 'AVR', 'MAI', 'JUIN', 'JUIL', 'AOÛT', 'SEPT', 'OCT', 'NOV', 'DÉC'];
        $moisLongs = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

        // Transforme une date en texte : "28 janvier 2026" (ou "28 janvier" sans l'année)
        $dateEnTexte = fn ($date, $avecAnnee = true) =>
            $date->day . ' ' . $moisLongs[$date->month - 1] . ($avecAnnee ? ' ' . $date->year : '');
    @endphp

    <div class="py-12 asimm-events">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Message de succès envoyé par le contrôleur --}}
            @if (session('success'))
                <div class="mb-4 p-4 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
            @endif

            @forelse ($evenements as $evenement)
                @php
                    // Date de fin réelle (si vide, l'événement dure une seule journée)
                    $fin = $evenement->end_date ?? $evenement->start_date;
                    // L'événement est passé quand sa date de fin est avant aujourd'hui
                    $estPasse = $fin->lt(today());
                    // Plusieurs jours si la date de fin est différente de la date de début
                    $plusieursJours = ! $fin->isSameDay($evenement->start_date);
                @endphp

                <div class="event-item {{ $estPasse ? 'is-past' : '' }}">

                    {{-- Bloc orange : jour et mois --}}
                    <div class="event-date">
                        <span class="day">{{ $evenement->start_date->format('d') }}</span>
                        <span class="month">{{ $moisCourts[$evenement->start_date->month - 1] }}</span>
                    </div>

                    <div class="event-content">
                        <div class="event-top">
                            {{-- À venir / Passé, et Brouillon si non publié --}}
                            <div>
                                <span class="event-label {{ $estPasse ? 'past' : '' }}">
                                    {{ $estPasse ? 'Passé' : 'À venir' }}
                                </span>
                                @unless ($evenement->is_published)
                                    <span class="badge-draft">Brouillon</span>
                                @endunless
                            </div>

                            {{-- Actions réservées à l'admin --}}
                            <div class="event-actions">
                                <a href="{{ route('admin.events.edit', $evenement->id) }}">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                <form method="POST" action="{{ route('admin.events.destroy', $evenement->id) }}"
                                      onsubmit="return confirm(@js('Supprimer « '.$evenement->title.' » ?'));">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"><i class="bi bi-trash"></i> Supprimer</button>
                                </form>
                            </div>
                        </div>

                        {{-- Titre --}}
                        <h3>{{ $evenement->title }}</h3>

                        {{-- Date, horaire et lieu --}}
                        <div class="event-meta">
                            <span>
                                <i class="bi bi-clock"></i>
                                @if ($plusieursJours)
                                    {{ $dateEnTexte($evenement->start_date, $evenement->start_date->year !== $fin->year) }}
                                    – {{ $dateEnTexte($fin) }}
                                @else
                                    {{ $dateEnTexte($evenement->start_date) }}
                                @endif
                                @if ($evenement->schedule)
                                    ({{ $evenement->schedule }})
                                @endif
                            </span>

                            @if ($evenement->location)
                                <span><i class="bi bi-geo-alt"></i> {{ $evenement->location }}</span>
                            @endif
                        </div>

                        {{-- Description (3 lignes maximum) --}}
                        <p class="event-description">{{ $evenement->description }}</p>

                        {{-- Bouton vers Eventbrite, LinkedIn... --}}
                        @if ($evenement->link_url)
                            <a href="{{ $evenement->link_url }}" target="_blank" rel="noopener" class="btn-event">
                                {{ $evenement->link_label ?: 'Détails' }} <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="events-empty">
                    <i class="bi bi-calendar-x"></i>
                    Aucun événement pour le moment.
                </div>
            @endforelse

            {{-- Liens de pagination --}}
            <div class="mt-4">
                {{ $evenements->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
