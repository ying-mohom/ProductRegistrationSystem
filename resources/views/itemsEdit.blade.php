@php

$currentUrl = url()->current();
$previousUrl = url()->previous();
if ($currentUrl != $previousUrl)
Session::put('requestReferrer', $previousUrl);
@endphp

@extends('layouts.app')

@section('title')
    Update Normal Register
@endsection

@section('content')
   
    <!-- content -->
    <div class=" mt-3 d-flex justify-content-start" style="margin-left: 150px;">
        <a href="{{ Session::get('requestReferrer') }}" class="text-decoration-none ms-3 fs-4" style="color:#276678;"><i
                class="fa-solid fa-angle-left fs-5" style="color:#276678;"></i> Back</a>
    </div>
    <div class="container mt-1">
        <div class="row justify-content-center">
            <div class="col-10">
               
                <!-- Show Error for Database not Store-->
                @if (session('fail'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fa-solid fa-exclamation text-danger"></i>
                        {{ session('fail') }}
                    </div>
                @endif

                <!-- Show Validation Error-->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        @foreach ($errors->all() as $error)
                            <i class="fa-solid fa-exclamation text-danger"></i>
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <div class="card shadow-lg">
                    <div class="card-header card-title text-center">
                        <h4 style="color:#276678;">{{ trans('language.item_update') }}</h4>
                    </div>
                    <!-- Normal Register Form -->
                    <div class="card-body">
                        <form action="{{ route('item.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <input type="text" name="id" value="{{ $item->id }}" hidden>
                            <div class="form-group row" style="margin-left: 100px;">

                                <label for="" class="col-sm-2  col-form-label">{{ trans('language.item id') }} <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control ms-5 w-75" name="itemId"
                                        value="{{ $item->item_id }}" disabled>
                                    <input type="text" class="form-control" name="itemId" value="{{ $item->item_id }}"
                                        hidden>
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.item code') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="text" class="form-control w-75 ms-5" name="itemCode"
                                        value="{{ $item->item_code }}">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.item name') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="text" class="form-control w-75 ms-5" name="itemName"
                                        value="{{ $item->item_name }}">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.category') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <div class="input-group mb-3 ms-5 w-75">

                                        <select class="form-control " aria-label="Default select example" id="selectBox"
                                            name="categoryId">
                                            <option value="{{ $item->category_id }}">{{ $item->category_name }} </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    @if (old('categoryId') == $category['id']) selected @endif>
                                                    {{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="input-group-text text-light" data-bs-toggle="modal"
                                            data-bs-target="#addCategory" data-backdrop="false"
                                            style="background-color:#1B6B93;">
                                            +
                                        </button>
                                        <button type="button" class="input-group-text text-light" data-bs-toggle="modal"
                                            data-bs-target="#removeCategory" data-backdrop="false"
                                            style="background-color:#1B6B93;">
                                            -
                                        </button>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.safety stock') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="number" class="form-control w-75 ms-5" name="safetyStock" min="0"
                                        value="{{ $item->safety_stock }}">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.date') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="date" class="form-control w-75 ms-5" id=""
                                        name="receivedDate" value="{{ $item->received_date }}">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.description') }}
                                </label>
                                <div class="col-sm-10">

                                    <textarea type="text" class="form-control w-75 ms-5" name="description" value="">{{ $item->description }}</textarea>
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for=""
                                    class="col-sm-2 col-form-label">{{ trans('language.upload photo') }}
                                </label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-group mb-3 ms-5">
                                                <input type="file" class="form-control" name="file" id="fileInput"
                                                    value="{{ old('file') }}" onchange="loadFile(event)">
                                                <input type="button" class="btn text-light"
                                                    style="background-color: #1B6B93;"
                                                    value="{{ trans('language.remove') }}" id="removeFile">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            @if ($fileName)
                                                <img src="{{ asset('fileUpload/' . $fileName) }}" width="90px"
                                                    height="90px" id="imageOutput" class="rounded border border-dark"
                                                    style="margin-left: 130px;">
                                            @else
                                                <img src="" width="90px" height="90px" id="imageOutput"
                                                    class="rounded border border-dark" style="margin-left:130px;"><br>
                                            @endif

                                        </div>
                                        <input type="hidden" id="removeImage" data-file-name="{{ $fileName }}"
                                            value="{{ $fileName }}">

                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" id="update" class="btn text-light"
                                        style="background-color: #1B6B93; width:100px;">{{ trans('language.update') }}</button>

                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Modal for Add Category -->
    <div class="modal" id="addCategory">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <div class="row m-auto">
                        <div class="col h4"> {{ trans('language.add category name') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeBtn"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row ms-1">
                        <div class="">
                            <input type="text" id="categoryName" name="categoryName"
                                placeholder=" * {{ trans('language.please enter category name') }}" class="form-control">
                            <span id="validateCategoryInput" class="text-danger text-center"></span>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn text-light fs-6 me-2" id="save"
                        style="background-color: #1B6B93;">{{ trans('language.save') }}</button>


                </div>

            </div>
        </div>
    </div>

    <!--Modal for Remove Category -->
    <div class="modal" id="removeCategory">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title m-auto">{{ trans('language.remove category name') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <select class="form-control" id="selectBox2" name="selectedValue">
                        <option selected id="noDeleteAbleCategory" value="noSelect">
                            {{ trans('language.choose category') }}</option>
                        @foreach ($itemsCategories as $itemsCategory)
                            <option value="{{ $itemsCategory->id }}">{{ $itemsCategory->category_name }}</option>
                        @endforeach
                    </select>
                    <span id="noCategorySelect" class="text-danger"></span>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer text-center">

                    <button type="button" class="btn text-light" id="remove"
                        style="background-color: #1B6B93;">{{ trans('language.remove') }}</button>

                </div>

            </div>
        </div>
    </div>
@endsection

<!--JQuery Function -->

@push('script')
    <script src="{{ asset('jquery/addCategory.js') }}" data-url="{{ route('categories.store') }}"></script>
    <script src="{{ asset('jquery/removeCategory.js') }}" data-url="{{ route('categories.remove') }}"></script>
    <script src="{{ asset('jquery/loadImage.js') }}"></script>
    <script src="{{ asset('jquery/removeImage.js') }}"></script>
@endpush
