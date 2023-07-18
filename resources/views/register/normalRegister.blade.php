@extends('layouts.app')

@section('title')
    Normal Register
@endsection

@section('content')


    <!-- content -->
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-10">
                <!-- Show Success Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fa-solid fa-circle-check text-success"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                <!--Show Success Message After Added Category -->

                 <div class="alert alert-success alert-dismissible fade show" id="showAlert" style="display: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                    <i class="fa-solid fa-circle-check text-success"></i>
                    <span id="alertMessage"></span>
                </div>
                 

                <!-- Show Error for data not store in database-->
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
                        <h4 style="color:#276678;">{{ trans('language.register form') }}</h4>
                    </div>
                    <div class="d-flex mt-3">
                        <div style="margin-left: 25px;">

                            <a href="{{ route('normal.registers') }}" class="text-decoration-none text-dark fs-5 ms-3">
                                <input type="radio" style="pointer-events:none;" checked>
                                {{ trans('language.normal register') }}
                            </a>


                        </div>
                        <div style="margin-left:250px;">

                            <a href="{{ route('excel.registers') }}" class="text-decoration-none text-dark fs-5 ms-3">
                                <input type="radio" style="pointer-events:none;"> {{ trans('language.excel register') }}
                            </a>


                        </div>
                    </div>
                    <hr>
                    <!-- Normal Register Form -->
                    <div class="card-body">
                        <form action="{{ route('store.item') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group row" style="margin-left: 100px;">

                                <label for="" class="col-sm-2  col-form-label">{{ trans('language.item id') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control ms-5 w-75" name="itemId"
                                        value="{{ $itemId }}" disabled>
                                    <input type="text" class="form-control" name="itemId" value="{{ $itemId }}"
                                        hidden>
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.item code') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="text" class="form-control w-75 ms-5" name="itemCode"
                                        value="{{ old('itemCode') }}" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.item name') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="text" class="form-control w-75 ms-5" name="itemName"
                                        value="{{ old('itemName') }}" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.category') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <div class="input-group mb-3 ms-5 w-75">

                                        <select class="form-control " aria-label="Default select example" id="selectBox"
                                            name="categoryId">
                                            <option selected disabled>{{ trans('language.choose category') }} </option>
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

                                <label for=""
                                    class="col-sm-2 col-form-label">{{ trans('language.safety stock') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="number" class="form-control w-75 ms-5" name="safetyStock"
                                        min="0" value="{{ old('safetyStock') }}" max="1000000" autocomplete="off">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.date') }}
                                    <span class="text-danger">*</span></label>
                                <div class="col-sm-10">

                                    <input type="date" class="form-control w-75 ms-5" id=""
                                        name="receivedDate" value="{{ old('receivedDate') }}">
                                </div>

                            </div>

                            <div class="form-group row mt-3" style="margin-left: 100px;">

                                <label for="" class="col-sm-2 col-form-label">{{ trans('language.description') }}
                                </label>
                                <div class="col-sm-10">

                                    <textarea type="text" class="form-control w-75 ms-5" name="description"  value="">{{ old('description') }}</textarea>
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
                                            <img src="" width="90px" height="90px" id="imageOutput"
                                                class="rounded border border-dark" style="margin-left: 130px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn text-light"
                                    style="background-color: #1B6B93; width:100px;">{{ trans('language.register') }}</button>

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
                    <h4 class="modal-title ms-5">{{ trans('language.remove category name') }}</h4>
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
