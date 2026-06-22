<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="{{ $page->meta_title }}" />

    <meta name="description" content="{{ $page->meta_description }}" />

    <meta name="keywords" content="{{ $page->meta_keywords }}" />
@endPush

<!-- Page Layout -->
<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ $page->meta_title ?: $page->page_title }}
    </x-slot>

    <!-- Page Header Banner -->
    <div class="border-b border-slate-200 bg-white">
        <div class="container px-[60px] pt-10 pb-6 max-1180:px-4">
            <nav class="mb-1.5 flex items-center gap-2 text-xs font-medium text-slate-400">
                <a href="{{ route('shop.home.index') }}" class="transition-colors hover:text-[#332a5e]">Home</a>
                <span class="icon-arrow-right rtl:icon-arrow-left text-sm text-slate-300"></span>
                <span class="text-[#332a5e]">Solutions</span>
                @if($page->page_title)
                    <span class="icon-arrow-right rtl:icon-arrow-left text-sm text-slate-300"></span>
                    <span class="text-[#332a5e]">{{ $page->page_title }}</span>
                @endif
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">{{ $page->page_title }}</h1>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container px-[60px] py-10 max-1180:px-4">
        {!! $page->html_content !!}
    </div>
</x-shop::layouts>
