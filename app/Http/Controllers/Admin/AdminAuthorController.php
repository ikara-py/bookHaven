<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AdminAuthorController extends Controller
{
    public function __construct(private AuthorService $authorService) {}

    public function index()
    {
        $authors = $this->authorService->listForAdmin();
        return view('admin.authors.index', compact('authors'));
    }

    public function store(StoreAuthorRequest $request)
    {
        $this->authorService->create($request->validated());
        return back()->with('success', 'Author created successfully.');
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $this->authorService->update($author, $request->validated());
        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author)
    {
        $this->authorService->delete($author);
        return back()->with('success', 'Author deleted successfully.');
    }
}
