<?php

namespace Webkul\Admin\Http\Controllers\Content;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Models\HomeBanner;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('admin::content.banners.index', [
            'banners' => HomeBanner::orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin::content.banners.form', ['banner' => new HomeBanner]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $banner = new HomeBanner($data);

        if ($request->hasFile('image')) {
            $banner->image_path = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        session()->flash('success', 'Banner added successfully.');

        return redirect()->route('admin.content.banners.index');
    }

    public function edit(int $id): View
    {
        return view('admin::content.banners.form', [
            'banner' => HomeBanner::findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $banner = HomeBanner::findOrFail($id);
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }
            $data['image_path'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        session()->flash('success', 'Banner updated successfully.');

        return redirect()->route('admin.content.banners.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $banner = HomeBanner::findOrFail($id);

        if ($banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
        }

        $banner->delete();

        return new JsonResponse(['message' => 'Banner deleted.']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'sometimes|boolean',
            'image'       => 'nullable|file|mimes:jpg,jpeg,png,webp|max:10240',
        ]);
    }
}
