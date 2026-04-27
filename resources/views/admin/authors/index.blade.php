@extends('layouts.app')

@section('content')
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-serif mb-2">Author <span class="text-(--color-primary)">Management</span></h1>
            <p class="text-(--color-muted) font-medium">Add, update, and manage the writers behind your book catalog.</p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center gap-4">
            <span class="text-xs font-black uppercase tracking-widest text-(--color-text) bg-(--color-bg) px-4 py-2 rounded-full border border-(--color-border) shadow-sm">
                {{ $authors->total() }} Total Authors
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) shadow-sm">
                <div class="hidden md:block">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-(--color-bg)/50 border-b border-(--color-border)">
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Author Profile</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Country</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted)">Books</th>
                                <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-(--color-muted) text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-(--color-border)">
                            @forelse($authors as $author)
                                <tr class="hover:bg-(--color-bg)/20 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-(--color-primary)/10 rounded-full flex items-center justify-center font-bold text-(--color-primary) border border-(--color-primary)/20">
                                                {{ substr($author->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-(--color-text)">{{ $author->name }}</p>
                                                @if($author->date_of_birth)
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-(--color-muted)">
                                                        Born: {{ $author->date_of_birth->format('Y') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($author->country)
                                            <span class="text-xs font-bold text-(--color-text)">{{ $author->country }}</span>
                                        @else
                                            <span class="text-xs text-(--color-muted) italic">---</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-(--color-text)">{{ $author->books_count }} Books</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative inline-block text-left">
                                            <button data-dropdown-toggle="author-dropdown-{{ $author->id }}" class="p-2 hover:bg-(--color-bg) rounded-full transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-muted)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                            </button>
                                            
                                            <div id="author-dropdown-{{ $author->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-48 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-xl z-50 overflow-hidden">
                                                <a href="{{ route('admin.authors.edit', $author->id) }}" class="flex items-center gap-3 px-4 py-3 text-xs font-bold text-(--color-primary) hover:bg-(--color-bg)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                                    Edit Profile
                                                </a>
                                                <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('Delete this author? All their books will remain, but will lose the author relation.');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-xs font-bold text-red-600 hover:bg-red-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                                        Delete Author
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-(--color-muted)">No authors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-(--color-border)">
                    @forelse($authors as $author)
                        <div class="p-5 space-y-4">
                            <div class="flex justify-between items-start">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-(--color-primary)/10 rounded-full flex items-center justify-center font-bold text-(--color-primary) border border-(--color-primary)/20">
                                        {{ substr($author->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-(--color-text)">{{ $author->name }}</p>
                                        <p class="text-[10px] text-(--color-muted) font-black uppercase tracking-widest">{{ $author->books_count }} Books</p>
                                    </div>
                                </div>
                                <div class="relative">
                                    <button data-dropdown-toggle="author-dropdown-mobile-{{ $author->id }}" class="p-2 bg-(--color-bg) rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-(--color-text)"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg>
                                    </button>
                                    <div id="author-dropdown-mobile-{{ $author->id }}" data-dropdown class="hidden absolute right-0 mt-2 w-48 bg-(--color-surface) border border-(--color-border) rounded-2xl shadow-2xl z-50 overflow-hidden">
                                        <a href="{{ route('admin.authors.edit', $author->id) }}" class="block px-4 py-3 text-xs font-bold text-(--color-primary) border-b border-(--color-border)">Edit Profile</a>
                                        <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full text-left px-4 py-3 text-xs font-bold text-red-600">Delete Author</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($author->country)
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-black uppercase text-(--color-muted) tracking-widest">Country:</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 bg-(--color-bg) border border-(--color-border) rounded">{{ $author->country }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-12 text-center text-(--color-muted)">No authors found.</div>
                    @endforelse
                </div>

                @if($authors->hasPages())
                    <div class="px-6 py-4 bg-(--color-bg) border-t border-(--color-border)">
                        {{ $authors->links() }}
                    </div>
                @endif
            </div>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="bg-(--color-surface) rounded-3xl border border-(--color-border) p-6 md:p-8 shadow-sm">
                <h3 class="text-xl font-serif mb-6 text-(--color-text)">Register <span class="text-(--color-primary)">New Author</span></h3>
                
                <form action="{{ route('admin.authors.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Author Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors" placeholder="e.g. Stephen King" required>
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="country" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Country (Optional)</label>
                        <input type="text" id="country" name="country" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors" placeholder="e.g. United States">
                        @error('country') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="date_of_birth" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Birth Date</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors">
                            @error('date_of_birth') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="date_of_death" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Death Date</label>
                            <input type="date" id="date_of_death" name="date_of_death" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors">
                            @error('date_of_death') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-black uppercase tracking-widest text-(--color-muted) mb-2">Biography</label>
                        <textarea id="description" name="description" rows="3" class="w-full bg-(--color-bg) border border-(--color-border) rounded-xl px-4 py-3 outline-none focus:border-(--color-primary) transition-colors resize-none" placeholder="Brief author bio..."></textarea>
                        @error('description') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-(--color-text) text-(--color-bg) py-4 rounded-xl font-bold hover:opacity-90 transition-all active:scale-[0.98]">
                        Register Author
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection
