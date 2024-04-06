<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            font-family: 'Times New Roman', Times, serif;
        }

        .wrapper {
            /* background-color: beige; */
            width: 600px;
            height: 600px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            position: relative;
        }

        .inner-wrapper {
            /* background-color: cadetblue; */
            /* margin: 20px 20px; */
            margin-top: 40px;
        }

        .header  img {
            width: 70px;
            height: 90px;
            margin-top: 40px;
        }
        .title-1 {
            position: absolute;
            right: 215px;
            top: 0;
            z-index: 999;
            font-size: 20px;
            font-weight: bolder;
        }

        .title-2 {
            position: absolute;
            right: 240px;
            top: 26px;
            z-index: 999;
            font-size: 20px;
            font-weight: 800;
        }

        .subtitle-1 {
            position: absolute;
            right: 100px;
            top: 56px;
            z-index: 999;
            font-size: 12px;
            font-weight: lighter;
            text-align: center;
            width: 400px
        }
        .subtitle-2 {
            position: absolute;
            right: 100px;
            top: 90px;
            z-index: 999;
            font-size: 12px;
            font-weight: lighter;
            text-align: center;
            width: 400px
        }

        .span-1 {
            margin-top: -6px;
            display: block
            width: 600px;
            height: 3px;
            background-color: #000;
        }

        .span-2 {
            margin-top: -10px;
            display: block
            width: 600px;
            height: 1px;
            background-color: #000;
        }

        .main-title-1 {
            margin-top: 40px;
            font-size: 18px;
            font-weight: bolder;
            text-align: center;
        } 

        .main-title-2 {
            margin-top: 6px;
            font-size: 18px;
            font-weight: bolder;
            text-align: center;
            text-decoration: underline;
        } 

        .main-subtitle-1 {
            margin-top: 40px;
            text-align: justify;
        }

        .detail-1 {
            margin-top: 20px;
        }

        .detail-1 div{
            position: relative;
            margin-bottom: 10px;
        }

        .detail-1 div .colon{
            position: absolute;
            top: 0;
            left: 120px;
        }

        .detail-1 div .data{
            position: absolute;
            top: 0;
            left: 140px;
        }

        .main-subtitle-2 {
            margin-top: 40px;
            text-align: justify;
        }

        .detail-2 {
            margin-top: 20px;
        }

        .detail-2 div{
            position: relative;
            margin-bottom: 10px;
        }

        .detail-2 div .colon{
            position: absolute;
            top: 0;
            left: 120px;
        }

        .detail-2 div .data{
            position: absolute;
            top: 0;
            left: 140px;
        }

        .main-subtitle-3 {
            margin-top: 40px;
            text-align: justify;
        }

        .footer {
            position: absolute;
            bottom: 120px;
            right: 90px;
        }

        .author {
            margin-top: 20px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="inner-wrapper">
            <div class="header">
                <img src="./img/logo-telkom.png" alt="">
                <h1 class="title-1"><b>Telkom University</b></h1>
                <h1 class="title-2"><b>TelkoMedika</b></h1>
                <p class="subtitle-1">Gedung Business Center, Jl. Telekomunikasi, Sukapura, Dayeuhkolot, Bandung Regency, West Java</p>
                <p class="subtitle-2">Email : <em style="color: blue">cs@telkomedika.co.id</em> ; Call Center : 1500115; Kode Pos : 40257</p>
                <div class="span-1"></div>
                <div class="span-2"></div>
            </div>
            <div class="main">
                <p class="main-title-1">
                    SURAT KETERANGAN
                </p>
                <p class="main-title-2">
                    HASIL PEMERIKSAAN
                </p>

                <p class="main-subtitle-1">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang bertanda tangan dibawah ini, <b>{{  $report->reservation->doctor->name }}</b>, menerangkan telah memeriksa  kesehatan badan : 
                </p>

                <div class="detail-1">
                    <div>Nim<p class="colon">:</p><p class="data">{{ $report->reservation->patient->student_id }}</p></div>
                    <div>Nama<p class="colon">:</p><p class="data">{{ $report->reservation->patient->name }}</p></div>
                    <div>Tanggal Lahir <p class="colon">:</p><p class="data">{{ $report->reservation->patient->birthdate }}</p></div>
                    <div>Jenis Kelamin <p class="colon">:</p><p class="data">{{ $report->reservation->patient->gender }}</p></div>
                    <div>Alamat <p class="colon">:</p><p class="data">{{ $report->reservation->patient->address }}</p></div>
                </div>

                <p class="main-subtitle-2">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Menurut hasil pemeriksaan yang telah kami lakukan dengan teliti, berikut merupakan hasil pemeriksaan yang di dapatkan : 
                </p>

                <div class="detail-2">
                    <div>Berat Badan<p class="colon">:</p><p class="data">{{ $report->weight }} kg</p></div>
                    <div>Tinggi Badan<p class="colon">:</p><p class="data">{{ $report->height }} cm</p></div>
                    <div>Suhu Badan<p class="colon">:</p><p class="data">{{ $report->temperature }}&#176; celcius</p></div>
                    <div>Keluhan <p class="colon">:</p><p class="data">{{ $report->initial_complaint }}</p></div>
                    <div>Diagnosa <p class="colon">:</p><p class="data">{{ $report->diagnosis }}</p></div>
                </div>

                <p class="main-subtitle-3">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan hasil pemeriksaan, pasien dinyatakan dalam keadaan <u>SAKIT</u> dan perlu mendapatkan istirahat yang cukup, demikian Surat Keterangan Ini untuk dapat digunakan seperlunya
                </p>
            </div>
            <div class="footer">
                <p class="date">Bandung, {{ date('d-m-Y'); }}</p>
                <p class="author">Penanggung Jawab</p>
            </div>
        </div>
    </div>
</body>
</html>