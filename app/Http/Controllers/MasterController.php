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
}
