@extends('layouts.app')

@section('title')
    Normal Register
@endsection

@section('content')


    <!-- content -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-10">
                <!-- Show Success Message-->
                @if (session('success'))
                    <div class="alert alert-success d-flex justify-content-between" id="alertBox">
                        <div class="col-6">
                            {{ session('success') }}
                        </div>
                        <div class="col-6 d-flex ">
                            <span class="btn" id="alertClose">&times;</span>
                        </div>

                    </div>
                @endif
                <!-- Show Error for Database not Store-->
                @if (session('fail'))
                    <div class="alert alert-success d-flex justify-content-between" id="alertBox">
                        <div class="col-6">
                            {{ session('success') }}
                        </div>
                        <div class="col-6 d-flex flex-row-reverse">
                            <span class="btn" id="alertClose">&times;</span>
                        </div>

                    </div>
                @endif

                <!-- Show Validation Error-->
                @if ($errors->any())
                    <div class="alert alert-danger" id="alertBox">
                        <div class="row">
                            <div class="col-6">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach

                            </div>
                            <div class="col-6 d-flex flex-row-reverse">
                                <div class="row">
                                    <div class="col">
                                        <span class="btn" id="alertClose">&times;</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                @endif
                <div class="card shadow-lg">
                    <div class="card-header card-title text-center">
                        <h4 style="color:#276678;">Register Form</h4>
                    </div>
                    <div class="d-flex mt-3">
                        <div style="margin-left: 25px;">

                            <a href="{{ route('normal.registers') }}" class="text-decoration-none text-dark fs-5 ms-3">
                                <input type="radio" style="pointer-events:none;" checked> Normal
                                Register
                            </a>


                        </div>
                        <div style="margin-left:250px;">

                            <a href="{{ route('excel.registers') }}" class="text-decoration-none text-dark fs-5 ms-3">
                                <input type="radio" style="pointer-events:none;"> Excel Upload Register
                            </a>


                        </div>
                    </div>
                    <hr>
                    <!-- Normal Register Form -->
                    <div class="card-body">
                        <form action="{{ route('store.item') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3">
                                        <label for="exampleFormControlFile1">Item
                                            ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="itemId"
                                            value="{{ $itemId }}" disabled>
                                        <input type="text" class="form-control" name="itemId"
                                            value="{{ $itemId }}" hidden>
                                    </div><br>
                                </div>
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3">
                                        <label for="exampleFormControlFile1">Item
                                            Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="itemCode"
                                            value="{{ old('itemCode') }}">
                                    </div><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3">
                                        <label for="exampleFormControlFile1">Item
                                            Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="itemName"
                                            value="{{ old('itemName') }}">
                                    </div><br>
                                </div>
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3">
                                        <label for="exampleFormControlFile1">Category
                                            Name <span class="text-danger">*</span></label>
                                        <div class="input-group mb-3">
                                           
                                                <select class="form-control" aria-label="Default select example"
                                                    id="selectBox" name="categoryId">
                                                    <option selected>Choose Category Name </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            @if (old('categoryId') == $category['id']) selected @endif>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>                                           
                                            <button type="button" class="input-group-text text-light"
                                                data-bs-toggle="modal" data-bs-target="#addCategory" data-backdrop="false"
                                                style="background-color:#1B6B93;">
                                                +
                                            </button>
                                            <button type="button" class="input-group-text text-light"
                                                data-bs-toggle="modal" data-bs-target="#removeCategory"
                                                data-backdrop="false" style="background-color:#1B6B93;">
                                                -
                                            </button>
                                        </div>
                                    </div><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group  ms-3 me-3">
                                        <label for="exampleFormControlFile1">Safety
                                            Stock <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="safetyStock" min="0"
                                            value="{{ old('safetyStock') }}">
                                    </div><br>
                                </div>
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3">
                                        <label for="exampleFormControlFile1">Received
                                            Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="" name="receivedDate"
                                            value="{{ old('receivedDate') }}">
                                    </div><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3">
                                        <label for="exampleFormControlFile1">Description</label>
                                        <textarea type="text" class="form-control" name="description" value="">{{ old('description') }}</textarea>
                                    </div><br>
                                </div>
                                <div class="col-6">
                                    <div class="form-group ms-3 me-3 justify-content-between">
                                        <label for="exampleFormControlFile1">UploadPhoto</label>
                                        <div class="input-group mb-3">
                                            <input type="file" class="form-control" name="file" id="fileInput"
                                                value="{{ old('file') }}" onchange="loadFile(event)">
                                            <input type="button" class="btn text-light"
                                                style="background-color: #1B6B93;" value="Remove" id="removeFile">
                                        </div>
                                        <img src="" width="90px" height="90px" id="imageOutput"
                                            class="rounded-circle border border-dark">
                                    </div><br>
                                </div>



                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn text-light fs-5"
                                    style="background-color: #1B6B93; width:100px;">Save</button>

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
                        <div class="col h4"> New Category Registration</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeBtn"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row ms-1">
                        <div class="">
                            <input type="text" id="categoryName" name="categoryName"
                                placeholder=" * Please Enter Category Name" class="form-control">
                            <span id="validateCategoryInput" class="text-danger text-center"></span>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn text-light fs-6 me-2" id="save"
                        style="background-color: #1B6B93;">Save</button>


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
                    <h4 class="modal-title">Category Remove</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <select class="form-control" id="selectBox2" name="selectedValue">
                        <option selected id="noDeleteAbleCategory">Select Category</option>
                        @foreach ($itemsCategories as $itemsCategory)
                            <option value="{{ $itemsCategory->id }}">{{ $itemsCategory->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer text-center">

                    <button type="button" class="btn text-light" id="remove"
                        style="background-color: #1B6B93;">Remove</button>

                </div>

            </div>
        </div>
    </div>

@endsection

<!--JQuery Function -->
@push('script')
    <script src="{{ asset('jquery/errorMessage.js') }}"></script>
    <script src="{{ asset('jquery/addCategory.js') }}" data-url="{{ route('categories.store') }}"></script>
    <script src="{{ asset('jquery/removeCategory.js') }}" data-url="{{ route('categories.remove') }}"></script>
    <script src="{{ asset('jquery/loadImage.js') }}"></script>
    <script src="{{ asset('jquery/removeImage.js') }}"></script>
@endpush
