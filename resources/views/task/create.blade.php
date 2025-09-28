<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Создание задачи') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Создать задачу') }}
                            </h2>
                        </header>

                        <form method="post" action="{{ route('tasks.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <div>
                                <x-input-label for="name" :value="__('Имя')"/>
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                              :value="old('name', $task->name)" autofocus
                                              autocomplete="name"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Описание')" />
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $task->description) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>

                            <div>
                                <x-input-label for="status_id" :value="__('Статус')" />
                                <select id="status_id" name="status_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Выберите статус') }}</option>
                                    @foreach($taskStatuses as $status)
                                        <option value="{{ $status->id }}" @selected(old('status_id', $task->status_id) === $status->id)>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status_id')" />
                            </div>

                            <div>
                                <x-input-label for="assigned_to_id" :value="__('Исполнитель')" />
                                <select id="user_id" name="assigned_to_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">{{ __('Выберите исполнителя') }}</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('assigned_to_id', $task->assigned_to_id) === $user->id)>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('assigned_to_id')" />
                            </div>

                            <div>
                                <x-input-label for="labels" :value="__('Метки')" />
                                <select id="labels" name="labels[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" size="5">
                                    @foreach($labels as $label)
                                        <option value="{{ $label->id }}" @if(in_array($label->id, old('labels', []))) selected @endif>
                                            {{ $label->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('labels')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Создать') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>