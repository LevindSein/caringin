<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Alat {{$status}} | BP3C</title>
        <link rel="stylesheet" href="{{asset('css/style-pemakaian1.css')}}" media="all"/>
        <link rel="icon" href="{{asset('img/logo.png')}}">
    </head>
    <style type="text/css">
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    </style>
    <body onload="window.print()">  
        @for($i=1;$i<=2;$i++)
        @if($i == 1)
        <main>
            <table class="tg">
                <thead>
                    <tr>
                        <th colspan="6" style="border-style:none;">
                            <h3 style="text-align:center;">REKAP TEMPAT USAHA {{strtoupper($status)}} ALAT LISTRIK<br>{{$now}}</h3>
                        </th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv">No.</th>
                        <th class="tg-r8fv">Blok</th>
                        <th class="tg-r8fv">Jml.Unit</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </main>
        @else
        <div style="page-break-before:always"></div>
        @foreach($rincianListrik as $data)
        <div>
            <main>
                <table class="tg">
                    <thead>
                        <tr>
                            <th colspan="8" style="border-style:none;">
                                <h3 style="text-align:center;">RINCIAN TEMPAT USAHA {{strtoupper($status)}} ALAT LISTRIK<br>{{$now}}<br>{{$data[0]}}</h3>
                            </th>
                        </tr>
                        <tr>
                            <th class="tg-r8fv">No.</th>
                            <th class="tg-r8fv">Kontrol</th>
                            <th class="tg-r8fv">Pengguna</th>
                            <th class="tg-r8fv" style="width:18%">Alamat</th>
                            <th class="tg-r8fv">Jml.Los</th>
                            <th class="tg-r8fv">Ket</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </main>
        </div>
        @endforeach
        @endif
        @endfor
        <div style="page-break-before:always"></div>
        @for($i=1;$i<=2;$i++)
        @if($i == 1)
        <main>
            <table class="tg">
                <thead>
                    <tr>
                        <th colspan="6" style="border-style:none;">
                            <h3 style="text-align:center;">REKAP TEMPAT USAHA {{strtoupper($status)}} ALAT AIR<br>{{$now}}</h3>
                        </th>
                    </tr>
                    <tr>
                        <th class="tg-r8fv">No.</th>
                        <th class="tg-r8fv">Blok</th>
                        <th class="tg-r8fv">Jml.Unit</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </main>
        @else
        <div style="page-break-before:always"></div>
        @foreach($rincianAirBersih as $data)
        <div>
            <main>
                <table class="tg">
                    <thead>
                        <tr>
                            <th colspan="8" style="border-style:none;">
                                <h3 style="text-align:center;">RINCIAN TEMPAT USAHA {{strtoupper($status)}} ALAT AIR<br>{{$now}}<br>{{$data[0]}}</h3>
                            </th>
                        </tr>
                        <tr>
                            <th class="tg-r8fv">No.</th>
                            <th class="tg-r8fv">Kontrol</th>
                            <th class="tg-r8fv">Pengguna</th>
                            <th class="tg-r8fv" style="width:18%">Alamat</th>
                            <th class="tg-r8fv">Jml.Los</th>
                            <th class="tg-r8fv">Ket</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </main>
        </div>
        @endforeach
        @endif
        @endfor
    </body>
</html>