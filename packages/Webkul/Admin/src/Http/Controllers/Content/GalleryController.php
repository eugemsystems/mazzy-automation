<?php

namespace Webkul\Admin\Http\Controllers\Content;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Models\GalleryItem;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin::content.gallery.index', [
            'items' => GalleryItem::orderBy('display_on')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin::content.gallery.form', ['item' => new GalleryItem]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $item = new GalleryItem($data);

        if ($request->hasFile('file')) {
            $item->file_path = $request->file('file')->store('gallery', 'public');
        }

        $item->save();

        session()->flash('success', 'Gallery item added successfully.');

        return redirect()->route('admin.content.gallery.index');
    }

    public function edit(int $id): View
    {
        return view('admin::content.gallery.form', [
            'item' => GalleryItem::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $item = GalleryItem::findOrFail($id);
        $data = $this->validated($request);

        if ($request->hasFile('file')) {
            if ($item->file_path) {
                Storage::disk('public')->delete($item->file_path);
            }
            $data['file_path'] = $request->file('file')->store('gallery', 'public');
        }

        $item->update($data);

        session()->flash('success', 'Gallery item updated successfully.');

        return redirect()->route('admin.content.gallery.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $item = GalleryItem::findOrFail($id);

        if ($item->file_path) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return new JsonResponse(['message' => 'Gallery item deleted.']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type'       => 'required|in:image,video',
            'title'      => 'nullable|string|max:255',
            'url'        => 'nullable|url|max:1000',
            'display_on' => 'required|in:gallery,our_work,both',
            'section'    => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'sometimes|boolean',
            'file'       => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm|max:51200',
        ]);
    }
}
