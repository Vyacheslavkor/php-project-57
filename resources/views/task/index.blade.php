<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Задачи') }}
        </h2>

        @auth
            <a href="{{ route('tasks.create') }}">
                <x-primary-button class="flex items-center space-x-2 mt-2">
                    <span class="ml-2 align-middle">{{ __('Создать задачу') }}</span>
                </x-primary-button>
            </a>
        @endauth
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="w-full flex items-center mb-4">
                        <form method="GET" action="{{ route('tasks.index') }}" class="flex w-full gap-2">
                            <select name="filter[status_id]" id="filter[status_id]"
                                    class="rounded border border-gray-300 px-3 py-2 w-1/3"
                            >
                                <option value="">{{ __('Статус') }}</option>
                                @foreach($taskStatuses as $status)
                                    <option value="{{ $status->id }}" @selected(request('filter.status_id') == $status->id)>{{ $status->name }}</option>
                                @endforeach
                            </select>

                            <select name="filter[created_by_id]" id="filter[created_by_id]"
                                    class="rounded border border-gray-300 px-3 py-2 w-1/3"
                            >
                                <option value="">{{ __('Автор') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(request('filter.created_by_id') == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>

                            <select name="filter[assigned_to_id]" id="filter[assigned_to_id]"
                                    class="rounded border border-gray-300 px-3 py-2 w-1/3"
                            >
                                <option value="">{{ __('Исполнитель') }}</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected(request('filter.assigned_to_id') == $user->id)>{{ $user->name }}</option>
                                @endforeach
                            </select>

                            <x-primary-button class="flex items-center space-x-2 ml-2 px-3 py-2 h-10">
                                <span class="ml-2 align-middle">{{ __('Применить') }}</span>
                            </x-primary-button>
                        </form>
                    </div>

                    @if ($tasks->count())
                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse" style="border-spacing: 0;">
                                <thead class="bg-gray-100">
                                <tr class="border-b border-gray-300">
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Статус
                                    </th>
                                    <th scope="col"
                                        class="w-1/3 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Имя
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Автор
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Исполнитель
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Дата создания
                                    </th>
                                    @auth
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                        >
                                            Действия
                                        </th>
                                    @endauth
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($tasks as $task)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $task->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $task->status->name }}</td>
                                        <td class="px-6 py-4 break-words text-sm text-blue-600 hover:underline"><a
                                                    href="{{ route('tasks.show', $task) }}"
                                            >{{ $task->name }}</a></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $task->creator->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">@if ($task->assignee)
                                                {{ $task->assignee->name }}
                                            @else
                                                ---
                                            @endif</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ Carbon\Carbon::parse($task->created_at)->format('d.m.Y') }}</td>
                                        @auth
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                <div class="flex flex-wrap justify-end gap-4 sm:flex-col sm:items-end">
                                                    <a href="{{ route('tasks.edit', $task) }}"
                                                       class="text-blue-600 hover:underline"
                                                    >Редактировать</a>

                                                    @if ($task->creator->id == auth()->id())
                                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                                              class="inline-flex" id="delete-form-{{ $task->id }}"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#"
                                                               class="text-red-600 hover:underline cursor-pointer"
                                                               onclick="event.preventDefault(); if(confirm('Вы уверены?')) { document.getElementById('delete-form-{{ $task->id }}').submit(); }"
                                                            >
                                                                Удалить
                                                            </a>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        @endauth
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @include('components.pagination', ['items' => $tasks])
                    @else
                        {{ __('Не найдено') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>