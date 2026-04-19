@extends('layouts.app')

@section('content')
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-serif mb-2">Category <span class="text-(--color-primary)">Management</span></h1>
            <p class="text-(--color-muted) font-medium">Organize the platform's book catalog horizontally and vertically.</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center gap-4">
            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex items-center w-full max-w-lg bg-(--color-surface) border border-(--color-border) rounded-2xl pl-4 pr-1.5 py-1.5 hover:border-(--color-primary)/50 focus-within:border-(--color-primary) transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" class="text-(--color-muted) ml-2" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search category name..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-1 text-sm bg-transparent outline-none placeholder-(--color-muted) text-(--color-text)"
                >
                @if(request('search'))
                    <a href="{{ route('admin.categories.index') }}" class="mr-3 text-(--color-muted) hover:text-red-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </a>
                @endif
                <button type="submit" class="bg-(--color-text) text-(--color-bg) text-[10px] font-black uppercase tracking-widest px-6 py-2.5 rounded-xl hover:opacity-90 transition-all active:scale-[0.95]">Search</button>
            </form>

            <span class="text-xs font-black uppercase tracking-widest text-(--color-text) bg-(--color-bg) px-4 py-2 rounded-full border border-(--color-border) shadow-sm">
                {{ $categories->total() }} Total Categories
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) overflow-hidden shadow-sm">
                <div class="hidden md:block">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-(--color-bg)/50 border-b border-(--color-border)">
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Category Name</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Parent</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Books Count</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-(--color-border)">
                            @forelse($categories as $category)
                                <tr class="hover:bg-(--color-bg)/20 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-(--color-accent)/10 rounded-xl flex items-center justify-center font-bold text-(--color-text) border border-(--color-border)">
                                                {{ substr($category->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-(--color-text)">{{ $category->name }}</p>
                                                @if($category->description)
                                                    <p class="text-xs text-(--color-muted) font-medium truncate w-48">{{ $category->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($category->parent)
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded bg-(--color-bg) border border-(--color-border)">
                                                {{ $category->parent->name }}
                                            </span>
                                        @else
                                            <span class="text-xs text-(--color-muted) italic">---</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-(--color-text)">{{ $category->books_count }} Books</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative inline-block text-left">
                                            <button data-dropdown-toggle="cat-dropdown-{{ $category->id }}" class="p-2 hover:bg-(--color-bg) rounded-full transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                            </button>
                                            
                                            <div id="cat-dropdown-{{ $category->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-48 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-xl z-50 overflow-hidden">
                                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-(--color-primary) hover:bg-(--color-bg)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                                    Edit Category
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-600 hover:bg-red-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                                        Delete Category
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-(--color-muted)">No categories found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-(--color-border)">
                    @forelse($categories as $category)
                        <div class="p-5 space-y-4">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-(--color-accent)/10 rounded-xl flex items-center justify-center font-bold text-(--color-text) border border-(--color-border)">
                                        {{ substr($category->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-(--color-text)">{{ $category->name }}</p>
                                        <p class="text-[10px] text-(--color-muted) font-black uppercase tracking-widest">{{ $category->books_count }} Books</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <button data-dropdown-toggle="cat-dropdown-mobile-{{ $category->id }}" class="p-2 bg-(--color-bg) rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-text)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </button>
                                    <div id="cat-dropdown-mobile-{{ $category->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-48 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-2xl z-50 overflow-hidden">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="block px-4 py-3 text-xs font-bold text-(--color-primary) border-b border-(--color-border)">Edit Category</a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold text-red-600">Delete Category</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($category->parent)
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black uppercase text-(--color-muted) tracking-widest">Parent:</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-(--color-bg) border border-(--color-border) rounded">{{ $category->parent->name }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-12 text-center text-(--color-muted)">No categories found.</div>
                    @endforelse
                </div>

                @if($categories->hasPages())
                    <div class="px-6 py-4 bg-(--color-bg) border-t border-(--color-border)">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) p-6 md:p-8 shadow-sm">
                <h3 class="text-xl font-serif mb-6 text-(--color-text)">Create <span class="text-(--color-primary)">New Category</span></h3>
                
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Category Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors" placeholder="e.g. Science Fiction" required>
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="parent_id" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Parent Category (Optional)</label>
                        <select id="parent_id" name="parent_id" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors cursor-pointer appearance-none">
                            <option value="">None (Top Level Category)</option>
                            @foreach($allCategories as $parentOpt)
                                <option value="{{ $parentOpt->id }}">{{ $parentOpt->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors resize-none" placeholder="Brief description..."></textarea>
                        @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-(--color-text) text-(--color-bg) py-4 rounded-xl font-bold hover:opacity-90 transition-all active:scale-[0.98]">
                        Publish Category
                    </button>
                </form>
            </div>
            

        </div>

    </div>
@endsection
