<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Encode+Sans+Expanded:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    />
    <style>
        .container {
            background-color: #06c458;
            width: 90%;
            max-width: 720px;
            margin: 0 auto;
            border: 5px solid #000;
            border-radius: 15px;
            text-align: center;
            font-family: 'Encode Sans Expanded', 'sans-serif';
        }
        .code {
            color: #fff;
            font-weight: 700;
            font-size: 24px;
        }
        .footertxt {
            color: #f6f8f8;
        }
    </style>
</head>
<body>
<div class="container">
    <img
        width="250"
        src="https://st2.depositphotos.com/3326513/46327/v/380/depositphotos_463279490-stock-illustration-open-letter-confirmation-email-concept.jpg?forcejpeg=true"
        alt="mail_img"
    />
    <p style="color: #fff">{{$body}}</p>
    <p class="code">{{$code}}</p>
</div>

</body>
</html>
