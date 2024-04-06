<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>خطأ 404 </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .error-container {
            text-align: center;
        }

        .error-img {
            max-width: 300px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="error-container">

        <img src="{{ asset('Assets/imgs/404.png') }}" alt="Error 404 Image" class="error-img img-fluid mb-0">
        <h1 class="h4 fw-bolder mt-2 mb-4">عذرًا، الخادم غير قادر حاليًا على تلبية طلبك بسبب أسباب مؤقتة. قد يكون الخادم تحت صيانة مجدولة أو يواجه ضغطًا زائدًا.</h1>

        <a href="{{ url()->previous() }}" class="btn btn-primary d-flex align-items-center justify-content-between m-auto" style="width: fit-content;">
            <img src="{{ asset('Assets/imgs/arrow-circle-right.png') }}" class="mr-2" alt="arrow"/>
            <span>العوده للخلف</span>
        </a>
    </div>
</body>

</html>
