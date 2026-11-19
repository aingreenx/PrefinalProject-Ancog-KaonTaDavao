@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <h1 class="font-display text-5xl font-black leading-[0.95] tracking-tight text-board">Edit {{ $eatery->name }}</h1>
        <p class="mt-2 mb-8 text-ink-soft">Changes to the name also change the page address.</p>

        {{-- HTML forms only send GET/POST; @method('PUT') adds a hidden _method field Laravel reads. --}}
        <form method="POST" action="{{ route('eateries.update', $eatery) }}" class="rounded-md border-[1.5px] border-line bg-[#fffaf0] p-6 sm:p-8" novalidate>
            @csrf
            @method('PUT')
            @include('eateries._form')

            <div class="mt-10 flex flex-wrap gap-3 border-t border-dashed border-line pt-6">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('eateries.show', $eatery) }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
