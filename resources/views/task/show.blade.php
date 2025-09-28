<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Задачи') }}
        </h2>

        @auth
            <a href="{{ route('tasks.edit', $task) }}">
                <x-primary-button class="flex items-center space-x-2 mt-2">
                    <span class="ml-2 align-middle">{{ __('Редактировать') }}</span>
                </x-primary-button>
            </a>
        @endauth
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Название</h3>
                        <p>{{ $task->name }}</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-1">Описание</h3>
                        <p class="whitespace-pre-line">{{ $task->description ?? 'Описание отсутствует' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Статус</h3>
                            <p>{{ $task->status->name ?? 'Не назначен' }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-1">Автор</h3>
                            <p>{{ $task->creator->name ?? 'Неизвестен' }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-1">Исполнитель</h3>
                            <p>{{ $task->assignee->name ?? 'Не назначен' }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-1">Дата создания</h3>
                            <p>{{ $task->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Метки</h3>
                        @if($task->labels->isEmpty())
                            <p class="text-gray-500">Метки отсутствуют</p>
                        @else
                            <div class="flex flex-wrap gap-4">
                                @foreach($task->labels as $label)
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-4 py-1 rounded-lg dark:bg-gray-700 dark:text-gray-400 border border-gray-500"> {{ $label->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @auth
                        @if(auth()->id() === $task->created_by_id)
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту задачу?');" class="mt-6">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                    Удалить задачу
                                </button>
                            </form>
                        @endif
                    @endauth

                    <div class="mt-8">
                        <a href="{{ route('tasks.index') }}" class="text-indigo-600 hover:underline">&larr; Вернуться к списку задач</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>