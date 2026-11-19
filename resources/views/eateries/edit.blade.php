@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-bold tracking-tight">Edit {{ $eatery->name }}</h1>

    {{-- HTML forms only send GET/POST; @method('PUT') adds a hidden _method field Laravel reads. --}}
    <form method="POST" action="{{ route('eateries.update', $eatery) }}" class="rounded-xl border border-stone-200 bg-white p-6">
        @csrf
        @method('PUT')
        @include('eateries._form')

        <div class="mt-8 flex gap-3">
            <button type="submit" class="rounded-lg bg-orange-600 px-5 py-2 font-semibold text-white hover:bg-orange-700">Save changes</button>
            <a href="{{ route('eateries.show', $eatery) }}" class="rounded-lg px-5 py-2 font-medium text-stone-600 hover:bg-stone-100">Cancel</a>
        </div>
    </form>
@endsection
