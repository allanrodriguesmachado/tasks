<x-layouts.app>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        @foreach([
            ['label' => 'Total',       'value' => $stats['total'],       'color' => 'slate',   'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['label' => 'Pendentes',   'value' => $stats['pending'],     'color' => 'amber',   'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'Andamento',   'value' => $stats['in_progress'], 'color' => 'blue',    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
            ['label' => 'Concluídas',  'value' => $stats['completed'],   'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ] as $card)
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 flex items-center gap-3 shadow-sm">
                <div class="w-10 h-10 rounded-lg bg-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <p class="text-2xl font-bold text-slate-800 dark:text-slate-100 font-mono">{{ $card['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>


    {{-- Filtros --}}
    <div x-data="{ open: {{ request()->hasAny(['status', 'priority', 'search']) ? 'true' : 'false' }} }"
         class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm mb-6">

        <button @click="open = !open"
                class="w-full flex items-center justify-between px-5 py-4 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 rounded-xl transition-colors">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
            </svg>
            Filtros
            @if(request()->hasAny(['status', 'priority', 'search']))
                <span class="bg-brand-500 text-white text-xs px-1.5 py-0.5 rounded-full">ativos</span>
            @endif
        </span>
            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open" x-collapse x-cloak>
            <form action="{{ route('tasks.index') }}" method="GET" class="px-5 pb-5 grid sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1.5">Buscar</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Título da tarefa..."
                           class="w-full text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1.5">Status</label>
                    <select name="status" class="w-full text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition">
                        <option value="">Todos</option>
                        <option value="pending"     {{ request('status') === 'pending'     ? 'selected' : '' }}>Pendente</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                        <option value="completed"   {{ request('status') === 'completed'   ? 'selected' : '' }}>Concluída</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 dark:text-slate-400 mb-1.5">Prioridade</label>
                    <select name="priority" class="w-full text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition">
                        <option value="">Todas</option>
                        <option value="high"   {{ request('priority') === 'high'   ? 'selected' : '' }}>Alta</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Média</option>
                        <option value="low"    {{ request('priority') === 'low'    ? 'selected' : '' }}>Baixa</option>
                    </select>
                </div>
                <div class="sm:col-span-3 flex gap-2 justify-end">
                    <a href="{{ route('tasks.index') }}" class="text-sm px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">Limpar</a>
                    <button type="submit" class="text-sm px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-medium transition-colors">Filtrar</button>
                </div>
            </form>
        </div>
    </div>


    {{-- Lista de Tarefas --}}
    @if($tasks->isEmpty())
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm py-16 flex flex-col items-center gap-3 text-center">
            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Nenhuma tarefa encontrada.</p>
            <a href="{{ route('tasks.create') }}" class="text-brand-500 hover:underline text-sm">Criar primeira tarefa →</a>
        </div>
    @else
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <ul class="divide-y divide-slate-100 dark:divide-slate-700">
                @foreach($tasks as $task)
                    <li x-data="{ confirm: false }"
                        class="flex items-center gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-700/40 transition-colors group">

                        {{-- Prioridade: indicador colorido --}}
                        <div class="w-1 self-stretch rounded-full flex-shrink-0 {{ match($task->priority) { 'high' => 'bg-red-400', 'medium' => 'bg-amber-400', default => 'bg-slate-300' } }}"></div>

                        {{-- Info principal --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-0.5">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="font-medium text-slate-800 dark:text-slate-100 hover:text-brand-600 dark:hover:text-brand-400 transition-colors truncate">
                                    {{ $task->title }}
                                </a>

                            </div>
                            <div class="flex items-center gap-3 text-xs text-slate-400 dark:text-slate-500">
                                @if($task->due_date)
                                    <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                                @endif
                                <span>{{ $task->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        {{-- Ações --}}
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('tasks.edit', $task) }}"
                               class="p-1.5 text-slate-400 hover:text-brand-600 hover:bg-brand-50 dark:hover:bg-brand-900/30 rounded-lg transition-colors"
                               title="Editar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            {{-- Delete com confirmação inline (Alpine.js) --}}
                            <div class="relative">
                                <button @click="confirm = true" x-show="!confirm"
                                        class="p-1.5 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                        title="Excluir">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>

                                <div x-show="confirm" x-cloak
                                     class="flex items-center gap-1 bg-white dark:bg-slate-800 border border-red-200 dark:border-red-800 rounded-lg px-2 py-1 shadow-lg">
                                    <span class="text-xs text-red-600 dark:text-red-400 mr-1">Excluir?</span>
                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white px-2 py-0.5 rounded transition-colors">Sim</button>
                                    </form>
                                    <button @click="confirm = false" class="text-xs text-slate-500 hover:text-slate-700 px-1">Não</button>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            {{-- Paginação --}}
            @if($tasks->hasPages())
                <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700">
                    {{ $tasks->links() }}
                </div>
            @endif
        </div>

        <p class="text-xs text-slate-400 dark:text-slate-500 mt-3 text-right">
            {{ $tasks->total() }} tarefa(s) encontrada(s)
        </p>
    @endif
</x-layouts.app>
