<?php

namespace Webkul\Admin\Http\Controllers\CMS;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\CMS\CMSPageDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\CMS\Repositories\PageRepository;
use Webkul\Core\Rules\Slug;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected PageRepository $pageRepository) {}

    /**
     * Loads the index page showing the static pages resources.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(CMSPageDataGrid::class)->process();
        }

        return view('admin::cms.index');
    }

    /**
     * To create a new CMS page.
     *
     * @return View
     */
    public function create()
    {
        return view('admin::cms.create');
    }

    /**
     * To store a new CMS page in storage.
     *
     * @return Response
     */
    public function store()
    {
        // Auto-generate url_key from page_title if not provided
        if (! request()->filled('url_key')) {
            request()->merge(['url_key' => \Illuminate\Support\Str::slug(request()->input('page_title'))]);
        }

        // Ensure uniqueness by appending a counter when slug already exists
        $urlKey = request()->input('url_key');
        $original = $urlKey;
        $counter = 1;
        while (\Webkul\CMS\Models\Page::whereTranslation('url_key', $urlKey)->exists()) {
            $urlKey = $original . '-' . $counter++;
        }
        request()->merge(['url_key' => $urlKey]);

        // Auto-assign default channel if none selected
        if (! request()->filled('channels')) {
            request()->merge(['channels' => [core()->getDefaultChannel()->id]]);
        }

        $this->validate(request(), [
            'url_key' => ['required', 'unique:cms_page_translations,url_key', new Slug],
            'page_title' => 'required',
            'html_content' => 'required',
            'channels' => 'required|array|min:1',
        ]);

        Event::dispatch('cms.page.create.before');

        $data = request()->only([
            'page_title',
            'channels',
            'html_content',
            'meta_title',
            'url_key',
            'meta_keywords',
            'meta_description',
        ]);

        $page = $this->pageRepository->create(array_merge($data, [
            'show_in_solutions' => (bool) request()->input('show_in_solutions', false),
            'parent_id'         => request()->input('parent_id') ?: null,
            'menu_label'        => request()->input('menu_label'),
            'sort_order'        => (int) request()->input('sort_order', 0),
        ]));

        Event::dispatch('cms.page.create.after', $page);

        session()->flash('success', trans('admin::app.cms.create-success'));

        return redirect()->route('admin.cms.index');
    }

    /**
     * To edit a previously created CMS page.
     *
     * @return View
     */
    public function edit(int $id)
    {
        $page = $this->pageRepository->findOrFail($id);

        return view('admin::cms.edit', compact('page'));
    }

    /**
     * To update the previously created CMS page in storage.
     *
     * @return Response
     */
    public function update(int $id)
    {
        $locale = core()->getRequestedLocaleCode();

        $this->validate(request(), [
            $locale.'.url_key' => ['required', new Slug, function ($attribute, $value, $fail) use ($id) {
                if (! $this->pageRepository->isUrlKeyUnique($id, $value)) {
                    $fail(trans('admin::app.cms.index.already-taken', ['name' => 'Page']));
                }
            }],
            $locale.'.page_title' => 'required',
            $locale.'.html_content' => 'required',
            'channels' => 'required|array|min:1',
        ]);

        Event::dispatch('cms.page.update.before', $id);

        $localeData = request()->input($locale);

        $page = $this->pageRepository->update([
            $locale          => $localeData,
            'channels'       => request()->input('channels'),
            'locale'         => $locale,
            'show_in_solutions' => (bool) request()->input('show_in_solutions', false),
            'parent_id'      => request()->input('parent_id') ?: null,
            'menu_label'     => request()->input('menu_label'),
            'sort_order'     => (int) request()->input('sort_order', 0),
        ], $id);

        Event::dispatch('cms.page.update.after', $page);

        session()->flash('success', trans('admin::app.cms.update-success'));

        return redirect()->route('admin.cms.index');
    }

    /**
     * To delete the previously create CMS page.
     */
    public function delete(int $id): JsonResponse
    {
        try {
            Event::dispatch('cms.page.delete.before', $id);

            $this->pageRepository->delete($id);

            Event::dispatch('cms.page.delete.after', $id);

            return new JsonResponse(['message' => trans('admin::app.cms.delete-success')]);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => trans('admin::app.cms.no-resource')]);
        }
    }

    /**
     * To mass delete the CMS resource from storage.
     */
    public function massDelete(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $indices = $massDestroyRequest->input('indices');

        foreach ($indices as $index) {
            Event::dispatch('cms.page.delete.before', $index);

            $this->pageRepository->delete($index);

            Event::dispatch('cms.page.delete.after', $index);
        }

        return new JsonResponse([
            'message' => trans('admin::app.cms.index.datagrid.mass-delete-success'),
        ], 200);
    }
}
