<?php

namespace Webkul\Admin\Http\Controllers\Content;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Models\Project;
use Webkul\Admin\Models\ProjectImage;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin::content.projects.index', [
            'projects' => Project::withCount('images')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin::content.projects.form', ['project' => new Project]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'sometimes|boolean',
            'images'      => 'nullable|array',
            'images.*'    => 'file|mimes:jpg,jpeg,png,webp|max:10240',
            'captions'    => 'nullable|array',
            'captions.*'  => 'nullable|string|max:255',
        ]);

        $project = Project::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        $this->storeImages($request, $project);

        session()->flash('success', 'Project created successfully.');

        return redirect()->route('admin.content.projects.index');
    }

    public function edit(int $id): View
    {
        return view('admin::content.projects.form', [
            'project' => Project::with('images')->findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'sometimes|boolean',
            'images'      => 'nullable|array',
            'images.*'    => 'file|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $project->update([
            'title'       => $request->input('title'),
            'description' => $request->input('description'),
            'sort_order'  => $request->input('sort_order', 0),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        $this->storeImages($request, $project);

        session()->flash('success', 'Project updated successfully.');

        return redirect()->route('admin.content.projects.index');
    }

    public function destroyImage(int $imageId): JsonResponse
    {
        $image = ProjectImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return new JsonResponse(['message' => 'Image deleted.']);
    }

    public function destroy(int $id): JsonResponse
    {
        $project = Project::with('images')->findOrFail($id);

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $project->delete();

        return new JsonResponse(['message' => 'Project deleted.']);
    }

    private function storeImages(Request $request, Project $project): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $sort = $project->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $idx => $file) {
            $path = $file->store('projects', 'public');
            $project->images()->create([
                'image_path' => $path,
                'caption'    => $request->input("captions.{$idx}"),
                'sort_order' => ++$sort,
            ]);
        }
    }
}
