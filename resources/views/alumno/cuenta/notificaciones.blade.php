@extends('layouts.alumno', ['title' => __('message.notifications_title')])

@section('content')
<div class="max-w-4xl mx-auto">
  <div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-extrabold mb-6">{{ __('message.notifications_heading') }}</h2>

    @if(empty($items))
      <div class="text-gray-500">{{ __('message.notifications_empty') }}</div>
    @else
      <ul class="space-y-3">
        @foreach($items as $it)
          <li class="border rounded-xl p-3 bg-white">{{ $it }}</li>
        @endforeach
      </ul>
    @endif
  </div>
</div>
@endsection
