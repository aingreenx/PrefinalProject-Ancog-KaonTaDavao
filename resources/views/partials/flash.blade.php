@if (session('status'))
    <div role="status" class="flash mb-8 flex items-center gap-3 rounded-md bg-board px-4 py-3 font-semibold text-chalk shadow-[0_8px_20px_-12px_rgb(20_42_31/0.6)]">
        <x-icon name="check" class="size-5 text-luyang" />
        <p>{{ session('status') }}</p>
    </div>
@endif
