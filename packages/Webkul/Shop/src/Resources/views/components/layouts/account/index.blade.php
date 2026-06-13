<x-shop::layouts :has-feature="false">
    <!-- Page Title -->
    <x-slot:title>
        {{ $title ?? '' }}
    </x-slot>

    <!-- Page Content -->
    <div class="min-h-screen bg-slate-50 py-8 max-md:py-4">
        <div class="container px-[60px] max-lg:px-8 max-md:px-4">
            <x-shop::layouts.account.breadcrumb />

            <div class="mt-5 flex items-start gap-6 max-lg:gap-5 max-md:mt-4 max-md:flex-col">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-shop::layouts>
