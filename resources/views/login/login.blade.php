<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css"
        integrity="sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"
        integrity="sha512-3dZ9wIrMMij8rOH7X3kLfXAzwtcHpuYpEgQg1OA4QAob1e81H8ntUQmQm3pBudqIoySO5j0tHN4ENzA6+n2r4w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>LogIn</title>

    <style>
        .error-message {
            background-color: #ffcccc;
            color: #e90a0a;
        }

        .box {
            background: #fff;
        }
    </style>

</head>

<body>
    <!-- Login Form -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-8">
                @if ($errors->any())
                    <div class="alert alert-danger" id="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
                    integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
                    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                <script>
                    $(document).ready(function() {
                        setTimeout(function() {
                            $('#error-message').fadeOut('slow');
                        }, 5000);
                    });
                </script>
                <div class="box shadow-lg" style="margin-top: 100px;">

                    <div class="row w-100">

                        <div class="col-6" style="background-color: #F4FAFF">
                            <img src="{{ asset('fileUpload/loginPhoto.png') }}" alt="" width="380px;"
                                height="350px;" class="mt-5">
                        </div>

                        <div class="col-6">
                            <div class="text-center mt-2">
                                <img src="{{ asset('fileUpload/mylogin.png') }}" alt="" width="80px;"
                                    height="80px;">
                            </div>
                            <h3 class="ms-3 mt-2 text-center">WELCOME</h3>
                            <form action={{ route('login') }} method="POST">
                                @csrf
                                @method('POST')
                                <div class="d-block mt-5">
                                    <div class="ms-3  mb-2">
                                        <label class="">Employee ID :</label>
                                    </div>
                                    <input type="text" class="form-control rounded-5 ms-2 me-2 w-100" id="emp_id"
                                        name="emp_id" placeholder="Enter Employee ID" value="{{ old('emp_id') }}" autocomplete="off"/>
                                </div>

                                <div class="d-block  mb-5 mt-3">
                                    <div class="ms-3 mb-2">
                                        <label class="">Password :</label>
                                    </div>
                                    <input type="password" class="form-control rounded-5 ms-2 me-2 w-100" id="emp_pwd"
                                        name="emp_pwd" placeholder=" Employee Password" />
                                </div>

                                <div class="ms-2">
                                    <button type="submit" class="btn text-light  rounded w-100"
                                        style="background-color:#1B6B93; width:380px; ">Login</button>
                                </div><br><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

