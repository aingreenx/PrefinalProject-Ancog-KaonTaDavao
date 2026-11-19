@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-bold tracking-tight">Add Eatery</h1>

    <form method="POST" action="{{ route('eateries.store') }}" class="rounded-xl border border-stone-200 bg-white p-6">
        @csrf
        @include('eateries._form')

        <div class="mt-8 flex gap-3">
            <button type="submit" class="rounded-lg bg-orange-600 px-5 py-2 font-semibold text-white hover:bg-orange-700">Add Eatery</button>
            <a href="{{ route('eateries.index') }}" class="rounded-lg px-5 py-2 font-medium text-stone-600 hover:bg-stone-100">Cancel</a>
        </div>
    </form>
@endsection
