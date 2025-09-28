<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Статусы') }}
        </h2>

        @auth
            <a href="{{ route('task_statuses.create') }}">
                <x-primary-button class="flex items-center space-x-2 mt-2">
                    <span class="ml-2 align-middle">{{ __('Создать статус') }}</span>
                </x-primary-button>
            </a>
        @endauth
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($taskStatuses->count())
                        <div class="overflow-x-auto">
                            <table class="w-full table-fixed border-collapse" style="border-spacing: 0;">
                                <thead class="bg-gray-100">
                                <tr class="border-b border-gray-300">
                                    <th scope="col"
                                        class="w-1/6 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="w-1/3 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Имя
                                    </th>
                                    <th scope="col"
                                        class="w-1/3 px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Дата создания
                                    </th>
                                    <th scope="col"
                                        class="w-1/6 px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    >
                                        Действия
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($taskStatuses as $status)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $status->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $status->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $status->created_at }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                            @auth
                                                <div class="flex flex-wrap justify-end gap-4 sm:flex-col sm:items-end">
                                                    <a href="{{ route('task_statuses.edit', $status) }}"
                                                       class="text-blue-600 hover:underline"
                                                    >Редактировать</a>

                                                    <form action="{{ route('task_statuses.destroy', $status) }}"
                                                          method="POST"
                                                          class="inline-flex"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-600 hover:underline"
                                                                onclick="return confirm('Вы уверены?')"
                                                        >Удалить</button>
                                                    </form>
                                                </div>
                                            @endauth
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @include('components.pagination', ['items' => $taskStatuses])
                    @else
                        {{ __('Не найдено') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>