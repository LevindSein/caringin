<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\TempatUsaha;
use App\Models\User;
use App\Models\StrukPembayaran;
use App\Models\Struk70mm;
use App\Models\Struk80mm;
use App\Models\Perkiraan;

use App\Models\Kasir;
use App\Models\Harian;
use App\Models\Item;

use App\Models\Sinkronisasi;

use App\Models\IndoDate;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\RawbtPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;

use Carbon\Carbon;
use DataTables;
use Exception;

class MasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('master');
    }

    public function kasir(Request $request){
        if($request->tanggal !== NULL || $request->tanggal != '')
            Session::put('masterkasir',$request->tanggal);
        else
            Session::put('masterkasir',date('Y-m-d',strtotime(Carbon::now())));
        if($request->ajax()){
            $data = Pembayaran::select('ref','kd_kontrol')
            ->groupBy('kd_kontrol','ref')
            ->orderBy('kd_kontrol','asc')
            ->where('tgl_bayar',Session::get('masterkasir'));
            return DataTables::of($data)
                ->addColumn('action', function($data){
                    $button = '<a type="button" title="Restore" name="restore" id="'.$data->ref.'" class="restore"><i class="fas fa-undo" style="color:#4e73df;"></i></a>&nbsp;&nbsp;';
                    $button .= '<a type="button" title="Edit" name="edit" id="'.$data->ref.'" class="edit"><i class="fas fa-edit" style="color:#e74a3b;"></i></a>&nbsp;&nbsp;';
                    $button .= '<a type="button" title="Cetak" name="cetak" id="'.$data->ref.'" class="cetak"><i class="fas fa-print" style="color:#1cc88a;"></a>';
                    return $button;
                })
                ->addColumn('pengguna', function($data){
                    $pengguna = TempatUsaha::where('kd_kontrol',$data->kd_kontrol)->select('id_pengguna')->first();
                    if($pengguna != NULL){
                        return User::find($pengguna->id_pengguna)->nama;
                    }
                    else{
                        return '(Kosong)';
                    }
                })
                ->addColumn('lokasi', function($data){
                    $lokasi = TempatUsaha::where('kd_kontrol',$data->kd_kontrol)->select('lok_tempat')->first();
                    if($lokasi != NULL){
                        return $lokasi->lok_tempat;
                    }
                    else{
                        return '';
                    }
                })
                ->addColumn('tagihan', function($data){
                    $tagihan = Pembayaran::where([['kd_kontrol',$data->kd_kontrol],['ref',$data->ref]])
                    ->select(DB::raw('SUM(realisasi) as tagihan'))->get();
                    if($tagihan != NULL){
                        return number_format($tagihan[0]->tagihan);
                    }
                    else{
                        return 0;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.kasir');
    }

    public function kasirRestore(Request $request, $ref){
        if($request->ajax()){
            try{
                $pembayaran = Pembayaran::where('ref',$ref)->get();
                foreach($pembayaran as $p){
                    $tagihan = Tagihan::find($p->id_tagihan);
                    if($tagihan != NULL){
                        if($p->byr_listrik == $tagihan->ttl_listrik && $p->byr_listrik !== NULL){
                            $tagihan->rea_listrik = 0;
                            $tagihan->sel_listrik = $tagihan->ttl_listrik;
                            $tagihan->den_listrik = $p->byr_denlistrik;
                            $tagihan->stt_lunas   = 0;
                        }

                        if($p->byr_airbersih == $tagihan->ttl_airbersih && $p->byr_airbersih !== NULL){
                            $tagihan->rea_airbersih = 0;
                            $tagihan->sel_airbersih = $tagihan->ttl_airbersih;
                            $tagihan->den_airbersih = $p->byr_denairbersih;
                            $tagihan->stt_lunas   = 0;
                        }

                        if($p->byr_keamananipk == $tagihan->ttl_keamananipk && $p->byr_keamananipk !== NULL){
                            $tagihan->rea_keamananipk = 0;
                            $tagihan->sel_keamananipk = $tagihan->ttl_keamananipk;
                            $tagihan->stt_lunas   = 0;
                        }

                        if($p->byr_kebersihan == $tagihan->ttl_kebersihan && $p->byr_kebersihan !== NULL){
                            $tagihan->rea_kebersihan = 0;
                            $tagihan->sel_kebersihan = $tagihan->ttl_kebersihan;
                            $tagihan->stt_lunas   = 0;
                        }

                        if($p->byr_airkotor == $tagihan->ttl_airkotor && $p->byr_airkotor !== NULL){
                            $tagihan->rea_airkotor = 0;
                            $tagihan->sel_airkotor = $tagihan->ttl_airkotor;
                            $tagihan->stt_lunas   = 0;
                        }

                        if($p->byr_lain == $tagihan->ttl_lain && $p->byr_lain !== NULL){
                            $tagihan->rea_lain = 0;
                            $tagihan->sel_lain = $tagihan->ttl_lain;
                            $tagihan->stt_lunas   = 0;
                        }
                        
                        $tagihan->stt_denda = $p->stt_denda;

                        //Subtotal
                        $subtotal = 
                                $tagihan->sub_listrik     + 
                                $tagihan->sub_airbersih   + 
                                $tagihan->sub_keamananipk + 
                                $tagihan->sub_kebersihan  + 
                                $tagihan->ttl_airkotor    + 
                                $tagihan->ttl_lain;
                        $tagihan->sub_tagihan = $subtotal;

                        //Diskon
                        $diskon = 
                            $tagihan->dis_listrik     + 
                            $tagihan->dis_airbersih   + 
                            $tagihan->dis_keamananipk + 
                            $tagihan->dis_kebersihan;
                        $tagihan->dis_tagihan = $diskon;

                        //Denda
                        $tagihan->den_tagihan = $tagihan->den_listrik + $tagihan->den_airbersih;

                        //TOTAL
                        $total = 
                            $tagihan->ttl_listrik     + 
                            $tagihan->ttl_airbersih   + 
                            $tagihan->ttl_keamananipk + 
                            $tagihan->ttl_kebersihan  + 
                            $tagihan->ttl_airkotor    + 
                            $tagihan->ttl_lain;
                        $tagihan->ttl_tagihan = $total;

                        //Realisasi
                        $realisasi = 
                                $tagihan->rea_listrik     + 
                                $tagihan->rea_airbersih   + 
                                $tagihan->rea_keamananipk + 
                                $tagihan->rea_kebersihan  + 
                                $tagihan->rea_airkotor    + 
                                $tagihan->rea_lain;
                        $tagihan->rea_tagihan = $realisasi;

                        //Selisih
                        $selisih =
                                $tagihan->sel_listrik     + 
                                $tagihan->sel_airbersih   + 
                                $tagihan->sel_keamananipk + 
                                $tagihan->sel_kebersihan  + 
                                $tagihan->sel_airkotor    + 
                                $tagihan->sel_lain;
                        $tagihan->sel_tagihan = $selisih;
                        
                        $tagihan->save();

                        $p->delete();
                    }
                    else{
                        return response()->json(['errors' => 'Restore Gagal']);
                    }
                }
    
                $struk = StrukPembayaran::where('ref',$ref)->first();
                if($struk != NULL){
                    $struk->delete();
                }
                return response()->json(['success' => 'Restore Sukses']);
            }
            catch(\Exception $e){
                return response()->json(['errors' => 'Restore Gagal']);
            }
        }
    }

    public function kasirEdit(Request $request){
        if($request->ajax()){
            try{
                $pembayaran = Pembayaran::where('ref',$request->hidden_ref)->get();
                if($pembayaran != NULL){
                    foreach($pembayaran as $d){
                        $tanggal = $request->edittanggal;
                        $d->tgl_bayar = $tanggal;
                        $d->bln_bayar = date("Y-m",strtotime($tanggal));
                        $d->thn_bayar = date("Y",strtotime($tanggal));
                        $d->save();
                    }
                }

                $struk = StrukPembayaran::where('ref', $request->hidden_ref)->get();
                if($struk != NULL){
                    foreach($struk as $d){
                        $tanggal = $request->edittanggal;
                        $d->tgl_bayar = $tanggal;
                        $d->bln_bayar = date("Y-m",strtotime($tanggal));

                        $bayar   = $d->bayar;
                        $pattern = date("d/m/Y", strtotime($tanggal));
                        $bayar   = substr_replace($bayar,$pattern,0,10);

                        $d->bayar = $bayar;
                        $d->save();
                    }
                }
                return response()->json(['success' => 'Berhasil Melakukan Update']);
            }
            catch(\Exception $e){
                return response()->json(['errors' => 'Gagal Melakukan Update']);
            }
        }
    }

    public function cetakStruk(Request $request, $struk, $id){
        if($struk == 'tagihan'){
            $struk = StrukPembayaran::where('ref',$id)->first();

            $listrik         = number_format($struk->taglistrik);
            $tunglistrik     = number_format($struk->tagtunglistrik);
            $denlistrik      = number_format($struk->tagdenlistrik);
            $dayalistrik     = number_format($struk->tagdylistrik);
            $awallistrik     = number_format($struk->tagawlistrik);
            $akhirlistrik    = number_format($struk->tagaklistrik);
            $pakailistrik    = number_format($struk->tagpklistrik);
            
            $airbersih       = number_format($struk->tagairbersih);
            $tungairbersih   = number_format($struk->tagtungairbersih);
            $denairbersih    = number_format($struk->tagdenairbersih);
            $awalairbersih   = number_format($struk->tagawairbersih);
            $akhirairbersih  = number_format($struk->tagakairbersih);
            $pakaiairbersih  = number_format($struk->tagpkairbersih);

            $keamananipk     = number_format($struk->tagkeamananipk);
            $tungkeamananipk = number_format($struk->tagtungkeamananipk);
            
            $kebersihan      = number_format($struk->tagkebersihan);
            $tungkebersihan  = number_format($struk->tagtungkebersihan);
            
            $airkotor        = number_format($struk->tagairkotor);
            $tungairkotor    = number_format($struk->tagtungairkotor);
            
            $lain            = number_format($struk->taglain);
            $tunglain        = number_format($struk->tagtunglain);

            $total           = number_format($struk->totalTagihan);

            if($struk->cetakan > 0)
                $cetakan     = number_format($struk->cetakan);
            else
                $cetakan     = 0;

            $dirfile = storage_path('app/public/logo_struk.png');
            $logo = EscposImage::load($dirfile,false);

            $bulan = IndoDate::bulanS($struk->bln_bayar, " ");

            $profile   = CapabilityProfile::load("POS-5890");
            $connector = new RawbtPrintConnector();
            $printer   = new Printer($connector,$profile);
            $i = 1;
            try{
                if(Session::get('printer') == 'panda'){
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> bitImageColumnFormat($logo, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> setEmphasis(true);
                    $printer -> text("Nama    : $struk->pedagang\n");
                    $printer -> text("Kontrol : $struk->kd_kontrol\n");
                    $printer -> text("Los     : $struk->los\n");
                    if($struk->lokasi != ''){
                        $printer -> text("Lokasi  : $struk->lokasi\n");
                    }
                    $printer -> text("No.Ref  : $struk->ref\n");
                    $printer -> setEmphasis(false);
                    $printer -> feed();
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("$bulan\n");
                    $printer -> feed();
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer -> text(new Struk80mm("Items","Rp.",true, true));
                    $printer -> selectPrintMode();
                    $printer -> setFont(Printer::FONT_B);
                    $printer -> text("----------------------------------------\n");
                    $feed = 0;
                    if($struk->taglistrik != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Listrik",$listrik,true));
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text(new Struk80mm("Daya" ,$dayalistrik,false));
                        $printer -> text(new Struk80mm("Awal" ,$awallistrik,false));
                        $printer -> text(new Struk80mm("Akhir",$akhirlistrik,false));
                        $printer -> text(new Struk80mm("Pakai",$pakailistrik,false));
                        $i++;
                        $feed = 1;
                    }
                    if($struk->tagtunglistrik != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Tgk.Listrik",$tunglistrik,true));
                        $i++;
                        $feed = 1;
                    }
                    if($struk->tagdenlistrik != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Den.Listrik",$denlistrik,true));
                        $i++;
                        $feed = 1;
                    }

                    if($feed == 1)
                        $printer -> feed();
                    
                    if($struk->tagairbersih != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Air Bersih",$airbersih,true));
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text(new Struk80mm("Awal" ,$awalairbersih,false));
                        $printer -> text(new Struk80mm("Akhir",$akhirairbersih,false));
                        $printer -> text(new Struk80mm("Pakai",$pakaiairbersih,false));
                        $i++;
                        $feed = 2;
                    }
                    if($struk->tagtungairbersih != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Tgk.Air Bersih",$tungairbersih,true));
                        $i++;
                        $feed = 2;
                    }
                    if($struk->tagdenairbersih != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Den.Air Bersih",$denairbersih,true));
                        $i++;
                        $feed = 2;
                    }
                    
                    if($feed == 2)
                        $printer -> feed();
                    
                    if($struk->tagkeamananipk != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Keamanan IPK",$keamananipk,true));
                        $i++;
                        $feed = 3;
                    }
                    if($struk->tagtungkeamananipk != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Tgk.Keamanan IPK",$tungkeamananipk,true));
                        $i++;
                        $feed = 3;
                    }
                    
                    if($feed == 3)
                        $printer -> feed();
                    
                    if($struk->tagkebersihan != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Kebersihan",$kebersihan,true));
                        $i++;
                        $feed = 4;
                    }
                    if($struk->tagtungkebersihan != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Tgk.Kebersihan",$tungkebersihan,true));
                        $i++;
                        $feed = 4;
                    }
                    
                    if($feed == 4)
                        $printer -> feed();
                    
                    if($struk->tagairkotor != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Air Kotor",$airkotor,true));
                        $i++;
                        $feed = 5;
                    }
                    if($struk->tagtungairkotor != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Tgk.Air Kotor",$tungairkotor,true));
                        $i++;
                        $feed = 5;
                    }
                    
                    if($feed == 5)
                        $printer -> feed();
                    
                    if($struk->taglain != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Lain Lain",$lain,true));
                        $i++;
                        $feed = 6;
                    }
                    if($struk->tagtunglain != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk80mm("$i. Tgk.Lain Lain",$tunglain,true));
                        $i++;
                        $feed = 6;
                    }
                    
                    if($feed == 6)
                        $printer -> feed();
                    
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer -> text(new Struk80mm("Total",$total,true,true));
                    $printer -> selectPrintMode();
                    $printer -> setFont(Printer::FONT_B);
                    $printer -> text("----------------------------------------\n");
                    if($cetakan != 0)
                        $printer -> text("Salinan ke-$cetakan\n");
                    $printer -> text("Nomor : $struk->nomor\n");
                    $printer -> text("Dibayar pada $struk->bayar\n");
                    $printer -> text("Harap simpan tanda terima ini\nsebagai bukti pembayaran yang sah.\nTerimakasih.\n");
                    $printer -> text("Ksr : $struk->kasir\n");
                    $printer -> feed();
                }
                else if(Session::get('printer') == 'androidpos'){

                }
                else{
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> bitImageColumnFormat($logo, Printer::IMG_DOUBLE_WIDTH | Printer::IMG_DOUBLE_HEIGHT);
                    $printer -> setJustification(Printer::JUSTIFY_LEFT);
                    $printer -> setEmphasis(true);
                    $printer -> text("Nama    : $struk->pedagang\n");
                    $printer -> text("Kontrol : $struk->kd_kontrol\n");
                    $printer -> text("Los     : $struk->los\n");
                    if($struk->lokasi != ''){
                        $printer -> text("Lokasi  : $struk->lokasi\n");
                    }
                    $printer -> text("No.Ref  : $struk->ref\n");
                    $printer -> setEmphasis(false);
                    $printer -> feed();
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> text("$bulan\n");
                    $printer -> feed();
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer -> text(new Struk70mm("Items","Rp.",true, true));
                    $printer -> selectPrintMode();
                    $printer -> setFont(Printer::FONT_B);
                    $printer -> text("----------------------------------------\n");
                    $feed = 0;
                    if($struk->taglistrik != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Listrik",$listrik,true));
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text(new Struk70mm("Daya" ,$dayalistrik,false));
                        $printer -> text(new Struk70mm("Awal" ,$awallistrik,false));
                        $printer -> text(new Struk70mm("Akhir",$akhirlistrik,false));
                        $printer -> text(new Struk70mm("Pakai",$pakailistrik,false));
                        $i++;
                        $feed = 1;
                    }
                    if($struk->tagtunglistrik != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Tgk.Listrik",$tunglistrik,true));
                        $i++;
                        $feed = 1;
                    }
                    if($struk->tagdenlistrik != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Den.Listrik",$denlistrik,true));
                        $i++;
                        $feed = 1;
                    }
                    
                    if($feed == 1)
                        $printer -> feed();
                    
                    if($struk->tagairbersih != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Air Bersih",$airbersih,true));
                        $printer -> setJustification(Printer::JUSTIFY_LEFT);
                        $printer -> text(new Struk70mm("Awal" ,$awalairbersih,false));
                        $printer -> text(new Struk70mm("Akhir",$akhirairbersih,false));
                        $printer -> text(new Struk70mm("Pakai",$pakaiairbersih,false));
                        $i++;
                        $feed = 2;
                    }
                    if($struk->tagtungairbersih != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Tgk.Air Bersih",$tungairbersih,true));
                        $i++;
                        $feed = 2;
                    }
                    if($struk->tagdenairbersih != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Den.Air Bersih",$denairbersih,true));
                        $i++;
                        $feed = 2;
                    }
                    
                    if($feed == 2)
                        $printer -> feed();
                    
                    if($struk->tagkeamananipk != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Keamanan IPK",$keamananipk,true));
                        $i++;
                        $feed = 3;
                    }
                    if($struk->tagtungkeamananipk != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Tgk.Keamanan IPK",$tungkeamananipk,true));
                        $i++;
                        $feed = 3;
                    }
                    
                    if($feed == 3)
                        $printer -> feed();
                    
                    if($struk->tagkebersihan != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Kebersihan",$kebersihan,true));
                        $i++;
                        $feed = 4;
                    }
                    if($struk->tagtungkebersihan != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Tgk.Kebersihan",$tungkebersihan,true));
                        $i++;
                        $feed = 4;
                    }
                    
                    if($feed == 4)
                        $printer -> feed();
                    
                    if($struk->tagairkotor != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Air Kotor",$airkotor,true));
                        $i++;
                        $feed = 5;
                    }
                    if($struk->tagtungairkotor != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Tgk.Air Kotor",$tungairkotor,true));
                        $i++;
                        $feed = 5;
                    }
                    
                    if($feed == 5)
                        $printer -> feed();
                    
                    if($struk->taglain != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Lain Lain",$lain,true));
                        $i++;
                        $feed = 6;
                    }
                    if($struk->tagtunglain != 0){
                        $printer -> setJustification(Printer::JUSTIFY_CENTER);
                        $printer -> text(new Struk70mm("$i. Tgk.Lain Lain",$tunglain,true));
                        $i++;
                        $feed = 6;
                    }
                    
                    if($feed == 6)
                        $printer -> feed();
                    
                    $printer -> setJustification(Printer::JUSTIFY_CENTER);
                    $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
                    $printer -> text(new Struk70mm("Total",$total,true,true));
                    $printer -> selectPrintMode();
                    $printer -> setFont(Printer::FONT_B);
                    $printer -> text("----------------------------------------\n");
                    if($cetakan != 0)
                        $printer -> text("Salinan ke-$cetakan\n");
                    $printer -> text("Nomor : $struk->nomor\n");
                    $printer -> text("Dibayar pada $struk->bayar\n");
                    $printer -> text("Harap simpan tanda terima ini\nsebagai bukti pembayaran yang sah.\nTerimakasih.\n");
                    $printer -> text("Ksr : $struk->kasir\n");
                    $printer -> feed();
                    $printer -> cut();
                }
            }catch(\Exception $e){
                return response()->json(['status' => 'Gagal Print Struk']);
            }finally{
                $printer->close();
            }
        }
    }

    public function dataPerkiraan(Request $request){
        $dataTahun = Tagihan::select('thn_tagihan')
        ->groupBy('thn_tagihan')
        ->get();

        if($request->ajax()){
            $data = Perkiraan::orderBy('id','desc');
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<a type="button" title="Edit" name="edit" id="'.$data->id.'" class="edit"><i class="fas fa-edit" style="color:#4e73df;"></i></a>';
                $button .= '&nbsp;&nbsp;<a type="button" title="Hapus" name="delete" id="'.$data->id.'" class="delete"><i class="fas fa-trash-alt" style="color:#e74a3b;"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('master.harian.perkiraan',[
            'dataTahun' => $dataTahun
        ]);
    }

    public function dataPerkiraanDestroy($id){
        $data = Perkiraan::findOrFail($id);
        try{
            $data->delete();
        }
        catch(\Exception $e){
            return response()->json(['error' => 'Data gagal dihapus.']);
        }
        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}
