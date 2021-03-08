<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Form Pengajuan Diskon Listrik | BP3C</title>
        <link rel="stylesheet" href="{{asset('css/form-diskon.css')}}" media="all"/>
        <link rel="icon" href="{{asset('img/logo.png')}}">
    </head>
    <body onload="window.print()">
        @foreach($dataset as $d)
        <div style="page-break-after:always;">
            <div class="row">
                <table class="tg" style="undefined; table-layout: fixed; width: 1200px">
                    <colgroup>
                    <col style="width: 101px">
                    <col style="width: 350px">
                    <col style="width: 100px">
                    <col style="width: 110px">
                    <col style="width: 310px">
                    </colgroup>
                    <!-- <thead>
                    <tr>
                        <th class="tg-spw9" colspan="4"></th>
                        <th class="tg-spw9">Formulir : Model GB-4</th>
                    </tr>
                    </thead> -->
                    <tbody>
                    <tr>
                        <td class="tg-m43w" colspan="5">KEMITRAAN KOPPAS PASAR INDUK BANDUNG-PT.LPP<br>BADAN PENGELOLA PUSAT PERDAGANGAN CARINGIN<br></td>
                    </tr>
                    <tr>
                        <td class="tg-5b4e" colspan="5"><span style="font-size:16px"><b><u>FORM PENGAJUAN DISKON LISTRIK</u></b></span></td>
                    </tr>
                    <tr>
                        <td class="tg-spw2" colspan="5">Yang bertanda tangan dibawah ini<br></td>
                    </tr>
                    <tr>
                        <td class="tg-spw2">Nama</td>
                        <td class="tg-spw2">: {{$d['nama']}}</td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2">Tagihan Lama</td>
                        <td class="tg-spw2">: .................................</td>
                    </tr>
                    <tr>
                        <td class="tg-spw2">Kd. Kontrol</td>
                        <td class="tg-spw2">: {{$d['kontrol']}}</td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2">Diskon</td>
                        <td class="tg-spw2">: ................................. %</td>
                    </tr>
                    <tr>
                        <td class="tg-spw2">Blok</td>
                        <td class="tg-spw2">: {{$d['blok']}}</td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2">Tagihan Baru</td>
                        <td class="tg-spw2">: .................................</td>
                    </tr>
                    <tr>
                        <td class="tg-spw2">No.Los</td>
                        <td class="tg-spw2">: {{$d['los']}}</td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2"></td>
                    </tr>
                    <tr>
                        <td class="tg-spw2">Jumlah Unit</td>
                        <td class="tg-spw2">: {{$d['unit']}}</td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2"></td>
                    </tr>
                    <tr>
                        <td class="tg-spw2">No. HP</td>
                        <td class="tg-spw2">: .................................</td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2"></td>
                        <td class="tg-spw2"></td>
                    </tr>
                    <tr>
                        <td class="tg-spw4" colspan="5">Mengajukan permohonan diskon tarif listrik. Sehubungan dengan permintaan tersebut diatas kami bersedia dan sanggup memenuhi ketentuan - ketentuan / peraturan - peraturan umum bagi pelanggan. Serta bersedia melampirkan <b><u>1 lembar fotokopi KTP</u></b> sebagai persyaratan pengajuan diskon</td>
                    </tr>
                    <tr>
                        <td class="tg-ex10" colspan="4"><textarea placeholder="Alasan : " style="height:75px;width:640px;"></textarea></td>
                        <td class="tg-exl0" style="vertical-align:bottom;" colspan="1">Bandung, {{$cetak}}</td>
                    </tr>
                    <tr>
                        <td class="tg-exl0" colspan="4">Mengetahui / Menyetujui,<br><br><br><br>(..........................)&nbsp&nbsp&nbsp(..........................)&nbsp&nbsp&nbsp(..........................)&nbsp&nbsp&nbsp(..........................)</td>
                        <td class="tg-exl0" colspan="1">Pemohon,<br><br><br><br>({{$d['nama']}})</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </body>
</html>