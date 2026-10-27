<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouvel événement
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.events.store') }}">
                    @csrf

                    {{-- Titre --}}
                    <div>
                        <x-input-label for="title" value="Titre *" />
                        <x-text-input id="title" name="title" class="block mt-1 w-full"
                                      :value="old('title')" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- Dates --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="start_date" value="Date de début *" />
                            <x-text-input id="start_date" name="start_date" type="date" class="block mt-1 w-full"
                                          :value="old('start_date')" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="end_date" value="Date de fin *" />
                            <x-text-input id="end_date" name="end_date" type="date" class="block mt-1 w-full"
                                          :value="old('end_date')" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Horaire et lieu --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="schedule" value="Horaire" />
                            <x-text-input id="schedule" name="schedule" class="block mt-1 w-full"
                                          placeholder="Ex. : 9h00 – 17h00"
                                          :value="old('schedule')" />
                            <x-input-error :messages="$errors->get('schedule')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="location" value="Lieu" />
                            <x-text-input id="location" name="location" class="block mt-1 w-full"
                                          placeholder="Ex. : Montréal, QC"
                                          :value="old('location')" />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mt-4">
                        <x-input-label for="description" value="Description *" />
                        <textarea id="description" name="description" rows="5" required
                                  class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Lien externe --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <x-input-label for="link_url" value="Lien (Eventbrite, LinkedIn...)" />
                            <x-text-input id="link_url" name="link_url" type="url" class="block mt-1 w-full"
                                          placeholder="https://..."
                                          :value="old('link_url')" />
                            <x-input-error :messages="$errors->get('link_url')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="link_label" value="Texte du bouton" />
                            <x-text-input id="link_label" name="link_label" class="block mt-1 w-full"
                                          placeholder="Ex. : S'inscrire"
                                          :value="old('link_label')" />
                            <x-input-error :messages="$errors->get('link_label')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Publication : cochée par défaut --}}
                    <div class="mt-4">
                        <label for="is_published" class="inline-flex items-center">
                            <input id="is_published" name="is_published" type="checkbox" value="1"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                   @checked(old('is_published', true))>
                            <span class="ms-2 text-sm text-gray-700">Publié (visible sur le site)</span>
                        </label>
                    </div>

                    {{-- Boutons --}}
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-600 hover:underline">Annuler</a>
                        <x-primary-button class="ms-4">Créer l'événement</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
