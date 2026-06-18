<x-shop::layouts>
    <x-slot:title>Projects - Mazzy Automations</x-slot>

    {{-- Breadcrumb --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Our Projects</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                    <li>Projects</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space-top space-extra-bottom">
        <div class="container">

            <div class="row justify-content-center mb-60">
                <div class="col-lg-8 text-center">
                    <div class="title-area">
                        <span class="sub-title"><i class="fas fa-hard-hat"></i> Completed Installations</span>
                        <h2 class="sec-title">Our Projects</h2>
                        <p class="sec-text">From smart home installations to complex industrial automation, see what we've built for our clients.</p>
                    </div>
                </div>
            </div>

            @forelse ($projects as $project)
                <div class="mb-60" style="border-bottom: 1px solid #eee; padding-bottom: 48px;">
                    <h3 class="sec-title mb-20" style="font-size: 1.5rem;">{{ $project->title }}</h3>

                    @if ($project->description)
                        <p class="mb-30" style="color: #555; line-height: 1.7;">{{ $project->description }}</p>
                    @endif

                    @if ($project->images->count())
                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                            @foreach ($project->images as $image)
                                <div style="flex: 0 0 auto;">
                                    <img
                                        src="{{ asset('storage/' . $image->image_path) }}"
                                        alt="{{ $image->caption ?? $project->title }}"
                                        loading="lazy"
                                        style="height: 220px; width: auto; max-width: 320px; border-radius: 8px; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.12);"
                                    >
                                    @if ($image->caption)
                                        <p style="margin-top: 6px; font-size: 12px; color: #777; text-align: center;">{{ $image->caption }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center" style="padding: 60px 0;">
                    <i class="fas fa-hard-hat" style="font-size: 48px; color: #ccc;"></i>
                    <p style="color: #888; margin-top: 16px; font-size: 1.1rem;">Projects coming soon. Check back later!</p>
                    <a href="{{ route('shop.home.contact_us') }}" class="th-btn mt-30" style="display: inline-block;">
                        Get a Quote <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @endforelse

            <div class="text-center mt-30">
                <a href="{{ route('shop.home.contact_us') }}" class="th-btn">Start Your Project <i class="fas fa-arrow-right ms-1"></i></a>
            </div>

        </div>
    </section>

</x-shop::layouts>
