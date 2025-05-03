<?php

namespace Ihossain\LaravelTags\Http\Controllers;

use App\Http\Controllers\Controller;
use Ihossain\LaravelTags\Helper\Helpers;
use Ihossain\LaravelTags\Http\Requests\Tag\TagStoreRequest;
use Ihossain\LaravelTags\Http\Requests\Tag\TagUpdateRequest;
use Ihossain\LaravelTags\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $moduleName = Helpers::getModuleName();

        $filters = $request->input('filter', []);

        $query = Tag::whereType($moduleName)->latest();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return Inertia::render('Tag/Index', [
            'moduleName' => $moduleName,
            'tags' => fn () => $query->paginate($request->get('per_page', 25))->withQueryString(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagStoreRequest $request): RedirectResponse
    {
        return back()->with([
            'success'   => 'Tag created successfully.',
            'data'      => Tag::create($request->validated())
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagUpdateRequest $request, $id): RedirectResponse
    {
        return back()->with([
            'success'   => 'Tag updated successfully.',
            'data'      => Tag::whereId($id)->update($request->validated())
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $tag = Tag::whereId($id)->delete();
        if ($tag) {
            return back()->with([
                'success'   => 'Tag deleted successfully.',
            ]);
        } else {
            return back()->with([
                'error'   => 'Tag could not be deleted.',
            ]);
        }
    }
}
