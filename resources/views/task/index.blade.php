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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:underline"><a
                                                    href="{{ route('tasks.show', $task) }}"
                                            >{{ $task->name }}</a></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $task->creator->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">@if ($task->assignee){{ $task->assignee->name }}@else --- @endif</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $task->created_at }}</td>
                                        @auth
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right">

                                                <div class="flex flex-wrap justify-end gap-4 sm:flex-col sm:items-end">
                                                    <a href="{{ route('tasks.edit', $task) }}"
                                                       class="text-blue-600 hover:underline"
                                                    >Редактировать</a>

                                                    @if (auth()->id() === $task->creator->id)
                                                        <form action="{{ route('tasks.destroy', $task) }}"
                                                              method="POST"
                                                              class="inline-flex"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="text-red-600 hover:underline"
                                                                    onclick="return confirm('Вы уверены?')"
                                                            >Удалить
                                                            </button>
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
                    @else
                        {{ __('Не найдено') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>