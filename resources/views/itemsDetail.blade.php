@php
    
    $currentUrl = url()->current();
    $previousUrl = url()->previous();
    if ($currentUrl != $previousUrl) {
        Session::put('requestReferrer', $previousUrl);
    }
    
@endphp
@extends('layouts.app')

@section('title')
    Item Detail
@endsection

@section('content')
<div class=" mt-5 d-flex justify-content-start" style="margin-left: 250px;">
    <a href="{{ Session::get('requestReferrer') }}" class="text-decoration-none ms-3 fs-4"
        style="color:#276678;"><i class="fa-solid fa-angle-left fs-5" style="color:#276678;"></i> Back</a>
</div>
    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class=" row rounded shadow-lg" style="background-color:#fff;">
                    <div class="col-6">
                        <h2 class="ms-3 mt-3">
                            {{ $item->item_name }}
                        </h2><br>
                        <table class="table w-100">
                            
                            <tr>
                                <th class="p-3">{{ trans('language.item id') }}</th>
                                <td class="p-3">{{ $item->item_id }} </td>
                            </tr>

                            <tr>
                                <th class="p-3">{{ trans('language.item code') }}</th>
                                <td class="p-3">{{ $item->item_code }}</td>
                            </tr>
                            <tr>
                                <th class="p-3">{{ trans('language.safety stock') }}</th>
                                <td class="p-3">{{ $item->safety_stock }}</td>
                            </tr>
                            <tr>
                                <th class="p-3">{{ trans('language.category') }}</th>
                                <td class="p-3">{{ $item->category_name }}</td>
                            </tr>
                            <tr>
                                <th class="p-3">{{ trans('language.date') }}</th>
                                <td class="p-3">{{ $item->received_date }}</td>
                            </tr>
                        </table>
                        <div class="d-inline">
                            <b class="fs-6 ms-3">{{ trans('language.description') }}</b>

                            <p class="ms-3">{{ $item->description }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        @if ($fileName)
                            <img src="{{ asset('fileUpload/' . $fileName) }}" width="100%" height="380px;"
                                class="pt-3 pb-3"><br>
                        @else
                            <img src="{{ asset('fileUpload/default-image.jpg') }}" width="100%" height="380px;"
                                class="pt-3 pb-3"><br>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
