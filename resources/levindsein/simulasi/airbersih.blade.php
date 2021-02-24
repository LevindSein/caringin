<?php
use App\Models\TarifAirBersih;

$tarif = TarifAirBersih::first();

$beban = $data['trf_beban'];
$tarif1 = $data['trf_1'];
$tarif2 = $data['trf_2'];
$pemeliharaan = $data['trf_pemeliharaan'];
$arkot = $data['trf_arkot'];
$denda = $data['trf_denda'];
$ppn = $data['trf_ppn'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Simulasi Air Bersih | BP3C</title>
        <link rel="stylesheet" href="{{asset('css/style-pemakaian.css')}}" media="all"/>
        <link rel="icon" href="{{asset('img/logo.png')}}">
    </head>
    <style type="text/css">
    table { page-break-inside:auto }
    tr    { page-break-inside:avoid; page-break-after:auto }
    </style>
    <body onload="window.print()">
        @for($i=1;$i<=2;$i++)
        @if($i == 1)
        @else
        <div style="page-break-before:always"></div>
        @foreach($rincian as $data)
        <div>
            <main>
                <table class="tg">
                    <thead>
                        <tr>
                            <th colspan="12" style="border-style:none;">
                                <h3 style="text-align:center;">SIMULASI RINCIAN PEMAKAIAN AIR BERSIH<br>{{$bln}}<br>{{$data[0]}}</h3>
                            </th>
                        </tr>
                        <tr>
                            <th class="tg-r8fv">No.</th>
                            <th class="tg-r8fv">Kontrol</th>
                            <th class="tg-r8fv">Pengguna</th>
                            <th class="tg-r8fv">M.Lalu</th>
                            <th class="tg-r8fv">M.Baru</th>
                            <th class="tg-r8fv">Pakai</th>
                            <th class="tg-r8fv">B.Pakai</th>
                            <th class="tg-r8fv">B.Beban</th>
                            <th class="tg-r8fv">B.Pemeliharaan </th>
                            <th class="tg-r8fv">B.Air Kotor</th>
                            <th class="tg-r8fv">Tagihan</th>
                            <th class="tg-r8fv" style="width:10%">Ket</th>
                            <!-- <th class="tg-r8fv">Realisasi</th>
                            <th class="tg-r8fv">Selisih</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $jml_bpakai    = 0;
                        $jml_beban     = 0;
                        $jml_pemeliharaan = 0;
                        $jml_arkot   = 0;
                        $jml_tagihan = 0;
                        ?>
                        @foreach($data[1] as $d)
                        <?php $tagihan = 0; ?>
                        <tr>
                            <td class="tg-cegc">{{$no}}</td>
                            <td class="tg-cegc">{{$d->kontrol}}</td>
                            <td class="tg-cegc" style="text-align:left;">{{$d->pengguna}}</td>
                            <td class="tg-cegc">{{number_format($d->lalu)}}</td>
                            <td class="tg-cegc">{{number_format($d->baru)}}</td>
                            <td class="tg-cegc">{{number_format($d->pakai)}}</td>

                            @if($d->pakai > 10)
                            <?php 
                            $a = 10 * $tarif1;
                            $b = ($d->pakai - 10) * $tarif2;
                            $byr_airbersih = $a + $b;
                            $tagihan = $tagihan + $byr_airbersih;
                            ?>
                            <td class="tg-cegc">{{number_format($byr_airbersih)}}</td>
                            @else
                            <?php
                            $byr_airbersih = $d->pakai * $tarif1;
                            $tagihan = $tagihan + $byr_airbersih;
                            ?>
                            <td class="tg-cegc">{{number_format($byr_airbersih)}}</td>
                            @endif

                            <?php
                            $tagihan = $tagihan + $beban;
                            ?>
                            <td class="tg-cegc">{{number_format($beban)}}</td>
                            
                            <?php
                            $tagihan = $tagihan + $pemeliharaan;
                            ?>
                            <td class="tg-cegc">{{number_format($pemeliharaan)}}</td>
                            
                            <?php 
                            $arkot_airbersih = ($arkot / 100) * $byr_airbersih;
                            $tagihan = $tagihan + $arkot_airbersih;
                            ?>
                            <td class="tg-cegc">{{number_format($arkot_airbersih)}}</td>

                            <?php
                            $ttl_tagihan = round($tagihan  + ($tagihan * ($ppn / 100)));
                            ?>
                            <td class="tg-cegc">{{number_format($d->tagihan)}}</td>
                            <td class="tg-cegc" style="white-space:normal; word-break:break-word;">{{$d->lokasi}}</td>
                            <!-- <td class="tg-cegc">{{number_format($d->realisasi)}}</td>
                            <td class="tg-cegc">{{number_format($d->selisih)}}</td> -->
                        </tr>
                        <?php 
                        $no++; 
                        $jml_bpakai    = $jml_bpakai + $byr_airbersih;
                        $jml_beban     = $jml_beban + $beban;
                        $jml_pemeliharaan = $jml_pemeliharaan + $pemeliharaan;
                        $jml_arkot   = $jml_arkot + $arkot_airbersih;
                        $jml_tagihan = $jml_tagihan + $ttl_tagihan;
                        ?>
                        @endforeach
                        @foreach($data[2] as $d)
                        <tr>
                            <td class="tg-vbo4" style="text-align:center;" colspan="5">Total</td>
                            <td class="tg-8m6k">{{number_format($d->pakai)}}</td>
                            <td class="tg-8m6k">{{number_format($jml_bpakai)}}</td>
                            <td class="tg-8m6k">{{number_format($jml_beban)}}</td>
                            <td class="tg-8m6k">{{number_format($jml_pemeliharaan)}}</td>
                            <td class="tg-8m6k">{{number_format($jml_arkot)}}</td>
                            <td class="tg-8m6k">{{number_format($jml_tagihan)}}</td>
                            <td class="tg-8m6k"></td>
                            <!-- <td class="tg-8m6k">{{number_format($d->realisasi)}}</td>
                            <td class="tg-8m6k">{{number_format($d->selisih)}}</td> -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </main>
            <div style="page-break-after:always"></div>
        </div>
        @endforeach
        @endif
        @endfor
    </body>
</html>