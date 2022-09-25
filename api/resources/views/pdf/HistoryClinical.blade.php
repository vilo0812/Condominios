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
                    <div class="col1">
                        <img src="icon/bicentenario.jpg" alt="logo ministerio" class="logo-img">
                    </div>
                    <div class="col2">
                        <img src="icon/icon2.jpg" alt="logo gobernación" class="logo-img2">
                    </div>
                </div>
        </div>
        <h1 class="header-title">
            Ministerio del Poder Popular para la Salud<br/>
            <br/>
            Centro de Diagnóstico Integral Tulio Pineda
        </h1>
        <div>
            <div class="datos">
                <p> Datos del Paciente </p>
                <p> fecha de impresion: {{$fecha}}</p>
                <table>
                    <tr>
                        <th class="center-text">Información</th>
                        <th class="center-text">Datos</th>
                    </tr>
                    <tr>
                        <td class="center-text">Nombre</td>
                        <td class="center-text">{{$patient->first_name}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Apellido</td>
                        <td class="center-text">{{$patient->last_name}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Cédula</td>
                        <td class="center-text">{{$patient->ci}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Género</td>
                        <td class="center-text">{{$patient->sex}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Teléfono</td>
                        <td class="center-text">{{$patient->phone}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Estado civil</td>
                        <td class="center-text">{{$patient->civil_status}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Fecha de Nacimiento</td>
                        <td class="center-text">{{$patient->birthdate}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Peso Kg</td>
                        <td class="center-text">{{$patient->weight}}</td>
                    </tr>
                    <tr>
                        <td class="center-text">Fecha de Registro</td>
                        <td class="center-text">{{Carbon\Carbon::parse($patient->created_at)->format('Y-m-d')}}</td>
                    </tr>
                </table>

            </div>
        </div>
        <div class="title m-b-md">
            Datos Clínicos
        </div>
        <div class="margin">
            <div>
                <h3>Patologias</h3>
            </div>
          <table>
              <tr>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Descriptión</th>

              </tr>
              @foreach($diseases as $item)
                  <tr>
                    <td style="text-align: center;">{{$item['name']}}</td>
                    <td style="text-align: center;">{{$item['description']}}</td>
                  </tr>
              @endforeach
          </table>
        </div>

         <div class="margin" style="padding-top: 100px;">
            <div>
                <h3> Antecedentes </h3>
             </div>
          <table>
              <tr>
                <th style="text-align: center;">Antecedente</th>
                <th style="text-align: center;">Descriptión</th>
              </tr>
              @foreach($antecedentes as $antecedente)
                  <tr>
                    <td style="text-align: center;">{{$antecedente['name']}}</td>
                    <td style="text-align: center;">{{$antecedente['description']}}</td>
                  </tr>
              @endforeach
          </table>
        </div>

         <div class="margin" style="padding-top: 100px;">
            <div>
                <h3> Medicamentos recetados</h3>
             </div>
          <table>
              <tr>
                <th style="text-align: center;">Medicamento</th>
                <th style="text-align: center;">Descriptión</th>
              </tr>
              @foreach($tratamientos as $medicina)
                  <tr>
                    <td style="text-align: center;">{{$medicina['medicine']}}</td>
                    <td style="text-align: center;">{{$medicina['description']}}</td>
                  </tr>
              @endforeach
          </table>
        </div>
    </div>

</body>
</html>