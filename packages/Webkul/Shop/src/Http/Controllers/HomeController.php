<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Webkul\Admin\Models\GalleryItem;
use Webkul\Admin\Models\HomeBanner;
use Webkul\Admin\Models\Project;
use Webkul\Category\Repositories\CategoryRepository;
use Webkul\Marketing\Repositories\FormSubmissionRepository;
use Webkul\Shop\Http\Requests\ContactRequest;
use Webkul\Shop\Http\Requests\QuoteRequest;
use Webkul\Shop\Http\Resources\CategoryTreeResource;
use Webkul\Shop\Mail\ContactUs;
use Webkul\Shop\Mail\QuoteRequest as QuoteRequestMail;
use Webkul\Theme\Repositories\ThemeCustomizationRepository;

class HomeController extends Controller
{
    /**
     * Using const variable for status
     */
    const STATUS = 1;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ThemeCustomizationRepository $themeCustomizationRepository,
        protected CategoryRepository $categoryRepository,
        protected FormSubmissionRepository $formSubmissionRepository
    ) {}

    /**
     * Loads the home page for the storefront.
     *
     * @return View
     */
    public function index()
    {
        $customizations = $this->themeCustomizationRepository->orderBy('sort_order')->findWhere([
            'status' => self::STATUS,
            'channel_id' => core()->getCurrentChannel()->id,
            'theme_code' => core()->getCurrentChannel()->theme,
        ]);

        $categories = $this->categoryRepository->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id);

        $categories = CategoryTreeResource::collection($categories);

        $banners = HomeBanner::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get();

        return view('shop::home.index', compact('customizations', 'categories', 'banners'));
    }

    /**
     * Store landing page — shows all products without a sidebar.
     */
    public function store(): View
    {
        return view('shop::store.index');
    }

    /**
     * Loads the home page for the storefront if something wrong.
     *
     * @return \Exception
     */
    public function notFound()
    {
        abort(404);
    }

    /**
     * Summary of contact.
     *
     * @return View
     */
    public function contactUs()
    {
        return view('shop::home.contact-us');
    }

    /**
     * About Us page.
     */
    public function aboutUs(): View
    {
        return view('shop::home.about-us');
    }

    /**
     * Gallery page.
     */
    public function gallery(): View
    {
        $items = GalleryItem::where('is_active', true)
            ->whereIn('display_on', ['gallery', 'both'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('shop::home.gallery', compact('items'));
    }

    /**
     * Our Work page.
     */
    public function ourWork(): View
    {
        $items = GalleryItem::where('is_active', true)
            ->whereIn('display_on', ['our_work', 'both'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('shop::home.our-work', compact('items'));
    }

    /**
     * Projects page.
     */
    public function projects(): View
    {
        $projects = Project::with('images')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('shop::home.projects', compact('projects'));
    }

    /**
     * Solutions detail page.
     */
    public function solutions(string $slug): View
    {
        return view('shop::home.solutions', compact('slug'));
    }

    /**
     * Planning and Design page.
     */
    public function planningAndDesign(): View
    {
        return view('shop::home.planning-and-design');
    }

    /**
     * Lutron Smart Control page.
     */
    public function lutronSmartControl(): View
    {
        return view('shop::home.lutron-smart-control');
    }

    /**
     * WiiM Home Audio page.
     */
    public function wiimHomeAudio(): View
    {
        return view('shop::home.wiim-home-audio');
    }

    /**
     * Denon Multi-room Audio page.
     */
    public function denonMultiRoomAudio(): View
    {
        return view('shop::home.denon-multi-room-audio');
    }

    /**
     * Polk Audio Sound System page.
     */
    public function polkAudioSoundSystem(): View
    {
        return view('shop::home.polk-audio-sound-system');
    }

    public function sendContactUsMail(ContactRequest $contactRequest): RedirectResponse
    {
        try {
            $data = $contactRequest->only(['name', 'email', 'contact', 'subject', 'message']);

            $this->formSubmissionRepository->create([
                'type'    => 'enquiry',
                'name'    => $data['name'],
                'email'   => $data['email'],
                'phone'   => $data['contact'] ?? null,
                'subject' => $data['subject'] ?? null,
                'message' => $data['message'],
            ]);

            Mail::queue(new ContactUs($data));

            session()->flash('success', trans('shop::app.home.thanks-for-contact'));
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            report($e);
        }

        return back();
    }

    public function sendQuoteMail(QuoteRequest $quoteRequest): RedirectResponse
    {
        try {
            $data = $quoteRequest->only(['name', 'email', 'phone', 'subject', 'message']);

            $this->formSubmissionRepository->create([
                'type'    => 'quote',
                'name'    => $data['name'],
                'email'   => $data['email'],
                'phone'   => $data['phone'] ?? null,
                'subject' => $data['subject'] ?? null,
                'message' => $data['message'],
            ]);

            Mail::queue(new QuoteRequestMail($data));

            session()->flash('success', 'Thank you! Your quote request has been received.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            report($e);
        }

        return back();
    }
}
