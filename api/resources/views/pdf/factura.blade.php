<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title></title>
    <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100%;
                margin: 0;
            }

            .full-height {
                height: 100%;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 5px;
            }
            table {
              border-collapse: collapse;
              width: 100%;
            }

            th, td {
              text-align: left;
              padding: 4px;
            }

            tr:nth-child(even){background-color: #f2f2f2}

            th {
              background-color: #000;
              color: white;
            }
            .margin{
                margin: auto 10;
            }
            .header{

            }

            .logo-img {
                width: 50px;
                margin:0px 10px;
            }
            .logo-img {
                width: 80px;
                align-items: left;
                margin-top: 30px;

            }
            .logo-img2 {
                width: 150px;
                align-items: left;
                margin-right: 50%;
                margin-top: 20px;

            }
            .header-title{
                color: black;
            }
            .item-sign{
                width: 100px;
                height: 100px;
            }
            .sign{
                margin-left: 30px;
                text-align: left;
                font-weight: bolder;
                color:black;
            }
            .img-sing{
                margin-left: 70px;
            }
            .row1{

            }
            .col1{
                display: inline-block;
                width:100px;
                padding-right:400px;
            }
            .col2{
                display: inline-block;
                width: 15px;
                padding-left:180px;
                padding-bottom: 25px;
            }
            .datos{
                border:1px solid black;
                margin:20px;
            }
            .center-text{
                text-align: center;
            }
        </style>
</head>
<body>
    <div class="content">
         <div class="header">
                <div>
                    {{-- <div class="col1">
                        <img src="icon/bicentenario.jpg" alt="logo ministerio" class="logo-img">
                    </div>
                    <div class="col2">
                        <img src="icon/icon2.jpg" alt="logo gobernación" class="logo-img2">
                    </div> --}}
                </div>
        </div>
        <h1 class="header-title">
            <br>
            Factura de cliente: {{$pago->condominio->user->name}}<br/>
            <br/>
        </h1>
        <div>
            <div class="datos">
                <p> El condominio : {{$pago->condominio->name}} </p>
            </div>
        </div>
        <div>
            Su pago de: {{ number_format((double)bcdiv($pago->amount, '1', 2), 2, '.', ',') }} <br>
            Fue procesado con exito.
        </div>
    </div>

</body>
</html>