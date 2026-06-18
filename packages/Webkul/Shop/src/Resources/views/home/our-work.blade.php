<x-shop::layouts>
    <x-slot:title>Our Work - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Our Work</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Our Work</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space-top space-extra-bottom">
        <div class="container">

            @if ($items->count())
                @php
                    $grouped = $items->groupBy(fn($i) => $i->section ?: 'General');
                @endphp

                @foreach ($grouped as $section => $sectionItems)
                    @if ($section !== 'General' || $grouped->count() > 1)
                        <h2 class="sec-title mb-30">{{ $section }}</h2>
                    @endif

                    <div class="d-flex flex-wrap gap-3 mb-60">
                        @foreach ($sectionItems as $item)
                            @if ($item->type === 'image')
                                <div>
                                    @if ($item->file_path)
                                        <img src="{{ asset('storage/' . $item->file_path) }}"
                                             alt="{{ $item->title ?? '' }}"
                                             style="max-height:320px; max-width:460px; border-radius:8px; object-fit:cover;"
                                             loading="lazy">
                                    @elseif ($item->url)
                                        <img src="{{ $item->url }}"
                                             alt="{{ $item->title ?? '' }}"
                                             style="max-height:320px; max-width:460px; border-radius:8px; object-fit:cover;"
                                             loading="lazy">
                                    @endif
                                    @if ($item->title)
                                        <p class="mt-2 text-center text-sm text-gray-600">{{ $item->title }}</p>
                                    @endif
                                </div>
                            @elseif ($item->type === 'video' && $item->url)
                                <div class="mz-fb-video">
                                    <iframe src="{{ $item->url }}"
                                        width="267" height="476"
                                        style="border:none;overflow:hidden;display:block;"
                                        scrolling="no" frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                        loading="lazy"></iframe>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach

            @else
                {{-- Static fallback while no DB items added --}}
                <h2 class="sec-title mb-30">Smart Lighting Systems</h2>
                <div class="d-flex flex-wrap gap-3 mb-60">
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F1635133803706127%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F1073055697624228%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F488604840875876%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F931350905509884%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                </div>

                <h2 class="sec-title mb-30">Smart Curtain Systems</h2>
                <div class="d-flex flex-wrap gap-3 mb-60">
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F1614870425777385%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=315&href=https%3A%2F%2Fwww.facebook.com%2Fmazzyautomations%2Fvideos%2F501806799259899%2F&show_text=false&width=560&t=0"
                            width="560" height="315" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F683643343091594%2F&show_text=false&width=476&t=0"
                            width="476" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                </div>

                <h2 class="sec-title mb-30">Smart Door Lock Systems</h2>
                <div class="d-flex flex-wrap gap-3 mb-60">
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F978995680663236%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                    <div class="mz-fb-video">
                        <iframe src="https://www.facebook.com/plugins/video.php?height=476&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F543134681659504%2F&show_text=false&width=267&t=0"
                            width="267" height="476" style="border:none;overflow:hidden;display:block;"
                            scrolling="no" frameborder="0" allowfullscreen="true"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                            loading="lazy"></iframe>
                    </div>
                </div>
            @endif

        </div>
    </section>

</x-shop::layouts>
