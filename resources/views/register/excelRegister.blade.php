@extends('layouts.app')
@section('title')
    Excel Register
@endsection
<style>
    .drop-container {
        position: relative;
        display: flex;
        gap: 10px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 400px;
        height: 200px;
        padding: 20px;
        border-radius: 10px;
        border: 2px dashed #555;
        color: #444;
        cursor: pointer;
        transition: background .2s ease-in-out, border .2s ease-in-out;
    }

    .drop-container:hover {
        background: #eee;
        border-color: #111;
    }

    input[type="file"] {
        outline: none;
        padding: 4px;
        margin: -4px;
    }

    input[type="file"]:focus-within::file-selector-button,
    input[type="file"]:focus::file-selector-button {
        outline: 2px solid #0964b0;
        outline-offset: 2px;
    }

    input[type="file"]::before {
        top: 16px;
    }

    input[type="file"]::after {
        top: 14px;
    }



    input[type="file"] {
        position: relative;
    }

    input[type="file"]::file-selector-button {
        width: 136px;
        color: transparent;
    }


    input[type="file"]::before {
        position: absolute;
        pointer-events: none;
        top: 10px;
        left: 40px;
        color: #0964b0;
        content: "{{ trans('language.upload file') }}";
    }

    input[type="file"]::after {
        position: absolute;
        pointer-events: none;
        top: 10px;
        left: 16px;
        height: 20px;
        width: 20px;
        content: "";
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230964B0'%3E%3Cpath d='M18 15v3H6v-3H4v3c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h-2zM7 9l1.41 1.41L11 7.83V16h2V7.83l2.59 2.58L17 9l-5-5-5 5z'/%3E%3C/svg%3E");
    }



    /* file upload button */
    input[type="file"]::file-selector-button {
        border-radius: 4px;
        padding: 0 16px;
        height: 40px;
        cursor: pointer;
        background-color: white;
        border: 1px solid rgba(0, 0, 0, 0.16);
        box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
        margin-right: 16px;
        transition: background-color 200ms;

    }
</style>

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-10">
                <!-- Error Message -->

                @if (session('error-message'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <i class="fa-solid fa-exclamation text-danger"></i>
                        {{ session('error-message') }}
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



                <div class="card shadow">
                    <div class="card-header card-title text-center">
                        <h4 style="color:#276678;">{{ trans('language.register form') }}</h4>
                    </div>
                    <div class="d-flex mt-3">
                        <div style="margin-left: 25px;">

                            <a href="{{ route('normal.registers') }}" class="text-decoration-none text-dark fs-5 ms-3">
                                <input type="radio" style="pointer-events:none;">
                                {{ trans('language.normal register') }}
                            </a>


                        </div>
                        <div style="margin-left:250px;">

                            <a href="{{ route('excel.registers') }}" class="text-decoration-none text-dark fs-5 ms-3">
                                <input type="radio" style="pointer-events:none;" checked>
                                {{ trans('language.excel register') }}
                            </a>


                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <form action="{{ route('import') }}" id="form2" class="form" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="d-flex justify-content-end">
                                <a href="{{ route('export') }}" class="btn p-2 text-light rounded"
                                    style="background-color:#1B6B93;"><i class="fa-solid fa-file-arrow-down fs-4"></i>
                                    {{ trans('language.excel download format') }}</a>
                            </div><br>
                            <div>
                                <label class="drop-container m-auto" id="dropcontainer">
                                    <input type="file" name="file">
                                </label>
                            </div><br><br>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn text-light "
                                    style="background-color: #1B6B93; width:100px;">{{ trans('language.save') }}</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
