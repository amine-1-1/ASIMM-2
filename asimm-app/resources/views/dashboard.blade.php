<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Événements
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($evenements->isEmpty())
                <div class="ev-empty">
                    <i class="bi bi-calendar-x"></i>
                    <p>Aucun événement disponible pour le moment.</p>
                </div>
            @else
                <div class="ev-list">
                    @foreach ($evenements as $evenement)
                    @php
                        // Dates en français
                        $debut = $evenement->start_date->locale('fr');
                        $fin = ($evenement->end_date ?? $evenement->start_date)->locale('fr');

                        // Mois abrégé pour le bloc orange : "janv." -> "JANV"
                        $mois = \Illuminate\Support\Str::upper(rtrim($debut->translatedFormat('M'), '.'));

                        // Texte de la date : "28 janvier 2026", "2–4 décembre 2026" ou "31 octobre – 2 novembre 2026"
                        if ($debut->isSameDay($fin)) {
                            $dateTexte = $debut->translatedFormat('j F Y');
                        } elseif ($debut->isSameMonth($fin)) {
                            $dateTexte = $debut->translatedFormat('j') . '–' . $fin->translatedFormat('j F Y');
                        } else {
                            $dateTexte = $debut->translatedFormat('j F') . ' – ' . $fin->translatedFormat('j F Y');
                        }

                        // À venir tant que la date de fin n'est pas passée
                        $aVenir = $fin->isToday() || $fin->isFuture();
                    @endphp

                        <div class="ev-card {{ $aVenir ? '' : 'is-past' }}">
                            {{-- Bloc orange : jour et mois --}}
                            <div class="ev-date">
                                <span class="day">{{ $debut->format('d') }}</span>
                                <span class="month">{{ $mois }}</span>
                            </div>

                            <div class="ev-content">
                                {{-- "À venir" seulement pour les événements futurs --}}
                                @if ($aVenir)
                                    <div class="ev-status">À venir</div>
                                @endif

                                <h3 class="ev-title">{{ $evenement->title }}</h3>

                                <div class="ev-meta">
                                    <span>
                                        <i class="bi bi-clock"></i>
                                        {{ $dateTexte }}@if ($evenement->schedule) ({{ $evenement->schedule }})@endif
                                    </span>
                                    @if ($evenement->location)
                                        <span><i class="bi bi-geo-alt"></i> {{ $evenement->location }}</span>
                                    @endif
                                </div>

                                {{-- Description complète, avec ses retours à la ligne --}}
                                <p class="ev-desc">{!! nl2br(e($evenement->description)) !!}</p>

                                @if ($evenement->link_url)
                                    <a href="{{ $evenement->link_url }}" class="ev-link" target="_blank" rel="noopener">
                                        {{ $evenement->link_label ?: 'Détails / Inscription' }} <i class="bi bi-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $evenements->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
