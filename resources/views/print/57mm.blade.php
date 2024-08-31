<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Receipt example</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
            * {
                font-size: 13px;
                font-family: "Roboto", sans-serif;
            }

            td,
            th,
            tr,
            table {
                border-top: 1px solid black;
                border-collapse: collapse;
            }

            td.titik,
            th.titik {
                width: 10px;
                max-width: 10px;
            }

            td.title,
            th.title {
                width: 70px;
                max-width: 70px;
                word-break: break-all;
            }

            td.value,
            th.value {
                width: 90px;
                max-width: 90px;
                word-break: break-all;
            }

            .centered {
                text-align: center;
                align-content: center;
            }

            .ticket {
                width: 170px;
                max-width: 170px;
            }

            @media print {
                .hidden-print,
                .hidden-print * {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body>
        <div class="ticket">
            <p class="centered"><strong>AKUN GURU</strong>
                <br>E-Presensi
                <br>SMA PGRI Cicalengka</p>
            <table>
                <tbody>
                    <tr>
                        <th class="title">ID User</th>
                        <td class="titik">:</td>
                        <td class="value">{{$dataGuru->id_user}}</td>
                    </tr>
                    <tr>
                        <th class="title">Nama GTK</th>
                        <td class="titik">:</td>
                        <td class="value">{{$dataGuru->nama_lengkap}}</td>
                    </tr>
                    <tr>
                        <th class="title">Password</th>
                        <td class="titik">:</td>
                        <td class="value">{{$dataGuru->token}}</td>
                    </tr>
                </tbody>
            </table>
            <p class="centered">Jangan lupa untuk mengganti
                <br>password di halaman profil</p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script>
            const $btnPrint = document.querySelector("#btnPrint");
            $btnPrint.addEventListener("click", () => {
                window.print();
            });
        </script>
    </body>
</html>
