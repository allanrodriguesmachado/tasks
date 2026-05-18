<x-layouts.app>
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('tasks.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 mb-3 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
                Voltar para tarefas
            </a>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Nova Tarefa</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Preencha os campos abaixo para criar uma nova
                tarefa.</p>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6"
             x-data="{ loading: false }">

            <form action="{{route('tasks.store')}}" method="POST" @submit="loading = true">
                @csrf


                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                        Título <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        placeholder="Ex: Revisar documentação do projeto"
                        autofocus
                        class="w-full text-sm border rounded-lg px-3 py-2.5 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 placeholder-slate-400
                   focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition
                   @error('title') border-red-400 dark:border-red-500 @else border-slate-300 dark:border-slate-600 @enderror">
                    @error('title')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ count: {{ strlen(old('description', $task?->description ?? '')) }} }">
                    <label for="description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                        Descrição
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        maxlength="2000"
                        placeholder="Detalhes sobre a tarefa (opcional)"
                        @input="count = $event.target.value.length"
                        class="w-full text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2.5 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 placeholder-slate-400
                   focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition resize-none
                   @error('description') border-red-400 @enderror"
                    >{{ old('description') }}</textarea>
                    <div class="mt-1 flex items-center justify-between">
                        @error('description')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                        @else
                            <span></span>
                            @enderror
                            <span class="text-xs text-slate-400" :class="{ 'text-red-500': count > 1900 }">
                <span x-text="count"></span>/2000
            </span>
                    </div>
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                        Prioridade <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="priority"
                        name="priority"
                        class="w-full text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2.5 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100
                       focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition
                       @error('priority') border-red-400 @enderror"
                    >
                        <option value="low"    {{ old('priority') === 'low'    ? 'selected' : '' }}>🟢 Baixa</option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>🟡 Média</option>
                        <option value="high"   {{ old('priority') === 'high'   ? 'selected' : '' }}>🔴 Alta</option>
                    </select>
                    @error('priority') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>


                <div>
                    <label for="due_date" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
                        Data de vencimento
                    </label>
                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        value="{{ old('due_date') }}"
                        class="w-full sm:w-64 text-sm border border-slate-300 dark:border-slate-600 rounded-lg px-3 py-2.5 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100
                   focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition
                   @error('due_date') border-red-400 @enderror"
                    >
                    @error('due_date') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div
                    class="mt-6 flex items-center justify-end gap-3 pt-5 border-t border-slate-100 dark:border-slate-700">
                    <a href="{{ route('tasks.index') }}"
                       class="text-sm px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        Cancelar
                    </a>


                    <button type="submit"
                            :disabled="loading"
                            class="inline-flex items-center gap-2 text-sm px-5 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-medium shadow-sm transition-colors disabled:opacity-70">
                        <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span x-text="loading ? 'Salvando...' : 'Criar Tarefa'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
