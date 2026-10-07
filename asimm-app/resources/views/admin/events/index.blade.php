<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Événements</h2>
        <p class="mt-1 text-sm text-gray-500">Aperçu des événements à venir.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="display:flex;justify-content:flex-end;margin-bottom:20px;">
                <a href="{{ route('admin.events.create') }}" class="admin-btn admin-btn-blue">
                    <i class="fa-solid fa-plus" style="margin-right:6px;"></i> Nouvel événement
                </a>
            </div>

            @if (session('success'))
                <div style="background:rgba(34,197,94,.1);border:1px solid rgba(34,197,94,.3);border-radius:10px;padding:12px 18px;margin-bottom:20px;color:#15803d;font-size:.9rem;font-weight:500;">
                    <i class="fa-solid fa-circle-check" style="margin-right:8px;"></i>{{ session('success') }}
                </div>
            @endif

            @if ($evenements->isEmpty())
                <div class="admin-card" style="text-align:center;padding:48px 24px;color:#94a3b8;">
                    <i class="fa-regular fa-calendar-xmark" style="font-size:2.5rem;margin-bottom:16px;display:block;"></i>
                    <p style="font-size:1rem;font-weight:500;">Aucun événement disponible.</p>
                </div>
            @else
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(340px,1fr));gap:20px;">
                    @foreach ($evenements as $evenement)
                        <div class="admin-card" style="margin-bottom:0;">

                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                                @if ($evenement->is_published)
                                    <span class="admin-badge admin-badge-green"><span class="admin-badge-dot"></span> Publié</span>
                                @else
                                    <span class="admin-badge admin-badge-yellow"><span class="admin-badge-dot"></span> Brouillon</span>
                                @endif
                                <div style="display:flex;gap:8px;">
                                    <a href="{{ route('admin.events.edit', $evenement->id) }}" class="admin-btn admin-btn-gray" style="padding:6px 14px;font-size:.8rem;">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $evenement->id) }}" onsubmit="return confirm('Supprimer cet événement ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-red" style="padding:6px 14px;font-size:.8rem;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <h3 style="margin:0 0 14px;font-size:1.1rem;font-weight:700;color:#0f172a;line-height:1.35;">{{ $evenement->title }}</h3>

                            <div style="display:grid;gap:9px;margin-bottom:16px;">
                                <div style="display:flex;align-items:center;gap:9px;font-size:.87rem;color:#475569;">
                                    <i class="fa-regular fa-calendar" style="color:#018880;width:16px;text-align:center;"></i>
                                    <span>
                                        {{ $evenement->start_date->format('d/m/Y') }}
                                        @if (!$evenement->start_date->eq($evenement->end_date))
                                            &rarr; {{ $evenement->end_date->format('d/m/Y') }}
                                        @endif
                                    </span>
                                </div>
                                @if ($evenement->schedule)
                                    <div style="display:flex;align-items:center;gap:9px;font-size:.87rem;color:#475569;">
                                        <i class="fa-regular fa-clock" style="color:#018880;width:16px;text-align:center;"></i>
                                        <span>{{ $evenement->schedule }}</span>
                                    </div>
                                @endif
                                @if ($evenement->location)
                                    <div style="display:flex;align-items:center;gap:9px;font-size:.87rem;color:#475569;">
                                        <i class="fa-solid fa-location-dot" style="color:#018880;width:16px;text-align:center;"></i>
                                        <span>{{ $evenement->location }}</span>
                                    </div>
                                @endif
                            </div>

                            <p style="font-size:.85rem;color:#64748b;margin:0 0 16px;line-height:1.6;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                                {{ $evenement->description }}
                            </p>

                            @if ($evenement->link_url)
                                <div style="padding-top:14px;border-top:1px solid #e2e8f0;">
                                    <a href="{{ $evenement->link_url }}" target="_blank" class="admin-btn admin-btn-blue" style="font-size:.82rem;padding:8px 18px;">
                                        <i class="fa-solid fa-arrow-up-right-from-square" style="margin-right:6px;"></i>
                                        {{ $evenement->link_label ?? 'En savoir plus' }}
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>

                @if ($evenements->hasPages())
                    <div class="admin-pagination">
                        @if ($evenements->onFirstPage())
                            <span class="admin-btn admin-btn-gray">Précédent</span>
                        @else
                            <a href="{{ $evenements->previousPageUrl() }}" class="admin-btn admin-btn-gray">Précédent</a>
                        @endif
                        <span>Page {{ $evenements->currentPage() }} sur {{ $evenements->lastPage() }}</span>
                        @if ($evenements->hasMorePages())
                            <a href="{{ $evenements->nextPageUrl() }}" class="admin-btn admin-btn-gray">Suivant</a>
                        @else
                            <span class="admin-btn admin-btn-gray">Suivant</span>
                        @endif
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>