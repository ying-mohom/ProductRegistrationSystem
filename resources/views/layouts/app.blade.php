<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title> @yield(' title ')</title>
    <link rel="icon" href="{{ asset('fileUpload/logo2.png') }}" type="image/x-icon">
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            border: 1px solid #e7e7e7;
            background-color: #fff;

        }

        .navigationBar li {
            float: left;
        }

        .navigationBar li a {
            display: block;
            color: #666;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navigation:hover,
        .navigation.active {
            background: none;
            color: #164B60;
            background: #bbbabaf1;
            height: 100%;
        }

        .custom-button {
            background-color: transparent;
            border: none;
            padding: 0;
            margin: 0;
            cursor: pointer;
            box-shadow: none;
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            border: none;
        }

        .dropdown a {
            color: #666;
        }

        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border: 0px;
        }
    </style>
</head>

<body style="background-color:#F4FAFF;">
    <div class="row">
        <ul class="shadow-sm navigationBar">
            <div class="d-flex justify-content-between mt-1">
                <div class="align-self-center  d-flex ">
                    <img src="{{ asset('fileUpload/logo2.png') }}" alt="" width="45px;" height="50px;"
                        class="ms-4 z-1">
                    <a href="{{ route('items.list') }}" class="text-decoration-none">

                        <h3 class="ms-2 mt-2 text-bold text-uppercase z-2" style="color:#276678;">
                            {{ trans('language.product registration system') }}
                        </h3>
                    </a>

                </div>
                <div class="d-flex justify-content-between me-3">
                    <li><a href="{{ route('normal.registers') }}"
                            class="fs-5 navigation">{{ trans('language.register') }}</a></li>
                    <li><a href="{{ route('items.list') }}"
                            class="fs-5 navigation me-2">{{ trans('language.list') }}</a></li>

                    <div class="dropdown me-2" style="margin-top:14px;">
                        <a class="dropdown-toggle  text-decoration-none" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false" style="font-size:19px;">{{ trans('language.language') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('language', 'mm') }}"><img
                                        src="{{ asset('fileUpload/myanmar.png') }}" width="30px;" height="30px;"
                                        alt="" class="me-4">{{ trans('language.myanmar') }}</a></li>
                            <li><a href="{{ route('language', 'en') }}"><img
                                        src="{{ asset('fileUpload/united-kingdom.png') }}" width="30px;"
                                        height="30px;"alt="" class="me-4">{{ trans('language.english') }}</a>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('login.form') }}"
                        class="btn text-light borderd-0 rounded-3 text-decoration-none text-center ms-3 mt-2 mb-1 "
                        style="height:43px;  background-color:#276678;">
                        <i
                            class="fa-solid fa-right-from-bracket text-light me-1 mt-1"></i>{{ trans('language.logout') }}
                    </a>
                </div>
            </div>
        </ul>
    </div>

    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">

    @stack('script')

</body>
