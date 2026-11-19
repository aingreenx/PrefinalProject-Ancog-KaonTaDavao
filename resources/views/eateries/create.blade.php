@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl">
        <h1 class="font-display text-5xl font-black tracking-tight text-board">Add Eatery</h1>
        <p class="mt-1 mb-8 text-ink-soft">List a carinderia with its district, features, and business permit.</p>

        <form method="POST" action="{{ route('eateries.store') }}" class="rounded-md border-[1.5px] border-line bg-[#fffaf0] p-6 sm:p-8" novalidate>
            @csrf
            @include('eateries._form')

            <div class="mt-10 flex flex-wrap gap-3 border-t border-dashed border-line pt-6">
                <button type="submit" class="btn btn-primary"><x-icon name="plus" />Add Eatery</button>
                <a href="{{ route('eateries.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
@endsection
