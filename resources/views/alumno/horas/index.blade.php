@extends('layouts.alumno', ['title' => __('message.hours_title')])

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-extrabold">{{ __('message.hours_heading') }}</h1>
            <p class="text-gray-500">{{ __('message.hours_subtitle') }}</p>
        </div>

        <a href="{{ route('horas.download') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition shadow">
            <i class="bi bi-download"></i>
            {{ __('message.hours_download') }}
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 text-sm">
                    <tr>
                        <th class="p-4 font-bold">{{ __('message.hours_date') }}</th>
                        <th class="p-4 font-bold">{{ __('message.hours_entry') }}</th>
                        <th class="p-4 font-bold">{{ __('message.hours_exit') }}</th>
                        <th class="p-4 font-bold">{{ __('message.hours_break') }}</th>
                        <th class="p-4 font-bold">{{ __('message.hours_total') }}</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                @forelse($fichajes as $f)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-semibold">
                            {{ \Carbon\Carbon::parse($f->fecha)->format('d/m/Y') }}
                        </td>

                        <td class="p-4">
                            @if($f->hora_entrada)
                                {{ $f->hora_entrada }}
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-700">
                                    {{ __('message.hours_absence') }}
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($f->hora_salida)
                                {{ $f->hora_salida }}
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-700">
                                    {{ __('message.hours_absence') }}
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($f->hora_entrada === null || $f->hora_salida === null)
                                <span class="text-gray-400">—</span>
                            @else
                                {{ ($f->minutos_descanso ?? 0) }} {{ __('message.hours_minutes') }}
                            @endif
                        </td>

                        <td class="p-4 font-extrabold">
                            @if($f->total_horas === null)
                                <span class="text-gray-400">—</span>
                            @else
                                {{ number_format((float)$f->total_horas, 2) }} h
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500 font-semibold">
                            {{ __('message.hours_empty') }}
                        </td>
                    </tr>
                @endforelse
                </tbody>

                @if($fichajes->count())
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="4" class="p-4 text-right font-extrabold text-gray-700">
                            {{ __('message.hours_total_footer') }}
                        </td>
                        <td class="p-4 font-extrabold text-gray-900">
                            {{ number_format((float)$totalHoras, 2) }} h
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection
