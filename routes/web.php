<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PedagangController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\DataUsahaController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\SimulasiController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;

use App\Http\Controllers\KasirController;
use App\Http\Controllers\KeuanganController;

use App\Http\Controllers\WorkController;
use App\Http\Controllers\DownloadController;

use App\Models\User;
use App\Models\LoginLog;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//HOME
Route::get('/', function(){
    return redirect()->route('login');
});
Route::get('login',function(){
    $time = "unknown";
    $now = Carbon::now();
    $start = Carbon::createFromTimeString('04:00');
    $end = Carbon::createFromTimeString('10:00');
    if ($now->between($start, $end)){
        $time = "pagi";
    }
    $start = Carbon::createFromTimeString('10:00');
    $end = Carbon::createFromTimeString('15:00');
    if ($now->between($start, $end)){
        $time = "siang";
    }
    $start = Carbon::createFromTimeString('15:00');
    $end = Carbon::createFromTimeString('19:00');
    if ($now->between($start, $end)){
        $time = "sore";
    }
    $start = Carbon::createFromTimeString('19:00');
    $end = Carbon::createFromTimeString('23:59');
    if ($now->between($start, $end)){
        $time = "malam";
    }
    $start = Carbon::createFromTimeString('00:00');
    $end = Carbon::createFromTimeString('04:00');
    if ($now->between($start, $end)){
        $time = "malam";
    }
    return view('home.login',['time'=>$time]);
})->name('login');

//LOGIN
Route::post('storelogin',function(Request $request){
    try{
        if(csrf_token() === $request->_token){
            if($request->role === 'master')
                return redirect()->route('dashboard')->with('success','Selamat Datang Master');
            else if($request->role === 'manajer')
                return redirect()->route('dashboard')->with('success','Selamat Datang Manajer');
            else if($request->role === 'kasir')
                return redirect()->route('kasir.index');
            else if($request->role === 'admin')
                return redirect()->route('dashboard')->with('success',"Selamat Datang $request->nama");
            else if($request->role === 'keuangan')
                return redirect()->route('keuangan.index');
            else
                abort(404);
        }
    }
    catch(\Exception $e){
        abort(404);
    }
})->middleware('ceklogin:home');
//LOGOUT
Route::get('logout',function(){
    Session::flush();
    Artisan::call('cache:clear');
    return redirect()->route('login')->with('success','Sampai Bertemu');
});

Route::middleware('ceklogin:dashboard')->group(function () {
    Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('ceklogin:kasir')->group(function(){
    Route::get('test/data/{data}',[KasirController::class, 'testdata']);

    Route::post('kasir/printer',[KasirController::class, 'printer']);

    Route::post('kasir/harian/{val}',[KasirController::class, 'harianval']);

    Route::get('kasir/settings',[KasirController::class, 'settings']);

    Route::get('kasir/harian/pendapatan',[KasirController::class, 'harianpendapatan']);
    Route::get('kasir/harian/penerimaan',[KasirController::class, 'harianpenerimaan']);

    Route::get('kasir/harian',[KasirController::class, 'harian'])->name('kasir.harian');
    Route::post('kasir/harian',[KasirController::class, 'harianpost']);

    Route::get('kasir/mode/{mode}',[KasirController::class, 'mode']);

    Route::get('kasir/utama',[KasirController::class, 'getutama']);
    Route::get('kasir/utama/bulan',[KasirController::class, 'getutamaBulan']);
    Route::get('kasir/sisa',[KasirController::class, 'getsisa']);
    Route::get('kasir/selesai',[KasirController::class, 'getselesai']);
    
    Route::get('kasir/restore',[KasirController::class, 'restore']);
    Route::post('kasir/restore/{id}',[KasirController::class, 'restoreStore']);

    Route::get('kasir/struk/{struk}',[KasirController::class, 'struk']);
    Route::get('kasir/struk/{struk}/{id}',[KasirController::class, 'cetakStruk']);
    
    Route::get('kasir/penerimaan',[KasirController::class, 'penerimaan']);
    
    // Route::get('kasir/periode',[KasirController::class, 'periode']);
    // Route::get('kasir/rincian/periode/{kontrol}',[KasirController::class, 'rincianPeriode']);
    
    // Route::post('kasir/periode',[KasirController::class, 'storePeriode']);
    // Route::post('kasir/bayar/periode/{kontrol}',[KasirController::class, 'bayarPeriode']);

    Route::get('kasir/bayar/{data}',[KasirController::class, 'bayar']);
    Route::get('kasir/rincian/{kontrol}',[KasirController::class, 'rincian']);
    Route::resource('kasir', KasirController::class);
});

Route::middleware('ceklogin:keuangan')->group(function(){
    Route::get('keuangan/checkout/arsip',[KeuanganController::class, 'arsip']);
    Route::get('keuangan/data/tunggakan',[KeuanganController::class, 'dataTunggakan']);
    Route::get('keuangan/data/tagihan',[KeuanganController::class, 'dataTagihan']);
    Route::get('keuangan/laporan/rekap/generate/{data}',[KeuanganController::class, 'lapGenerateRekap']);
    Route::get('keuangan/laporan/rekap/{data}',[KeuanganController::class, 'lapRekap']);
    Route::get('keuangan/laporan/pendapatan/generate/{data}',[KeuanganController::class, 'lapGeneratePendapatan']);
    Route::get('keuangan/laporan/pendapatan/{data}',[KeuanganController::class, 'lapPendapatan']);
    Route::get('keuangan/laporan/tagihan/generate/{data}',[KeuanganController::class, 'lapGenerateTagihan']);
    Route::get('keuangan/laporan/tagihan/{data}',[KeuanganController::class, 'lapTagihan']);
    Route::resource('keuangan', KeuanganController::class);
});

Route::middleware('ceklogin:layanan')->group(function (){
    Route::post('layanan/pengajuan/diskon',[LayananController::class, 'diskon']);
    Route::get('layanan/tempat/{data}',[LayananController::class, 'tempat']);
    Route::resource('layanan', LayananController::class);
});

Route::middleware('ceklogin:pedagang')->group(function (){
    Route::post('pedagang/update', [PedagangController::class, 'update']);
    Route::get('pedagang/destroy/{id}', [PedagangController::class, 'destroy']);
    Route::resource('pedagang', PedagangController::class);
});

Route::middleware('ceklogin:tempatusaha')->group(function (){
    Route::get('tempatusaha/alat', [TempatController::class, 'alat']);
    Route::get('tempatusaha/qr/{id}',[TempatController::class, 'qr']);
    Route::get('tempatusaha/rekap', [TempatController::class, 'rekap']);
    Route::get('tempatusaha/rekap/{blok}',[TempatController::class, 'rekapdetail']);
    Route::get('tempatusaha/fasilitas/{fas}',[TempatController::class, 'fasilitas']);
    Route::post('tempatusaha/update', [TempatController::class, 'update']);
    Route::get('tempatusaha/destroy/{id}', [TempatController::class, 'destroy']);
    Route::resource('tempatusaha', TempatController::class);
});

Route::middleware('ceklogin:tagihan')->group(function (){
    Route::get('tagihan/tempat', [TagihanController::class, 'tempat']);
    Route::post('tagihan/neraca', [TagihanController::class, 'neracaStore']);
    Route::get('tagihan/neraca', [TagihanController::class, 'neraca']);
    Route::get('tagihan/manual/{id}', [TagihanController::class, 'manual']);
    Route::post('tagihan/sinkronisasi', function(Request $request){
        if($request->ajax()){
            try{
                Artisan::call('cron:tagihan');
                return response()->json(['success' => 'Sinkronisasi Sukses']);
            }
            catch(\Exception $e){
                return response()->json(['errors' => 'Oops! Sinkronisasi Gagal']);
            }
        }
    });
    Route::get('tagihan/pemberitahuan/{blok}', [TagihanController::class, 'pemberitahuan']);
    Route::post('tagihan/unpublish/{id}', [TagihanController::class, 'unpublish']);
    Route::get('tagihan/pembayaran/{blok}', [TagihanController::class, 'pembayaran']);
    Route::get('tagihan/periode', [TagihanController::class, 'periode']);
    Route::post('tagihan/tambah', [TagihanController::class, 'tambah']);
    Route::get('tagihan/publish', [TagihanController::class, 'publish']);
    Route::post('tagihan/publish', [TagihanController::class, 'publishStore']);
    Route::get('tagihan/pesan/{id}', [TagihanController::class, 'pesan']);
    Route::post('tagihan/review', [TagihanController::class, 'reviewStore']);
    Route::post('tagihan/review/{id}', [TagihanController::class, 'review']);
    Route::get('tagihan/notification', [TagihanController::class, 'notification']);
    Route::get('tagihan/listrik', [TagihanController::class, 'listrik'])->name('listrik');
    Route::get('tagihan/airbersih', [TagihanController::class, 'airbersih'])->name('airbersih');
    Route::post('tagihan/listrik', [TagihanController::class, 'listrikUpdate']);
    Route::post('tagihan/airbersih', [TagihanController::class, 'airbersihUpdate']);
    Route::get('tagihan/print', [TagihanController::class, 'print']);
    Route::post('tagihan/update', [TagihanController::class, 'update']);
    Route::get('tagihan/destroy/edit/{id}', [TagihanController::class, 'destroyEdit']);
    Route::post('tagihan/destroy/{id}', [TagihanController::class, 'destroy']);
    Route::resource('tagihan', TagihanController::class);
});

Route::middleware('ceklogin:pemakaian')->group(function(){
    Route::get('rekap/pemakaian', [PemakaianController::class, 'index']);
    Route::get('rekap/pemakaian/{fasilitas}/{bulan}',[PemakaianController::class, 'fasilitas']);
});

Route::middleware('ceklogin:pendapatan')->group(function(){
    Route::get('rekap/pendapatan/tahunan', [PendapatanController::class, 'tahunan']);
    Route::get('rekap/pendapatan/bulanan', [PendapatanController::class, 'bulanan']);
    Route::resource('rekap/pendapatan', PendapatanController::class);
});

Route::middleware('ceklogin:datausaha')->group(function(){
    Route::get('datausaha/penghapusan', [DataUsahaController::class, 'penghapusan']);
    Route::get('datausaha/bongkaran', [DataUsahaController::class, 'bongkaran']);
    Route::get('datausaha/tunggakan', [DataUsahaController::class, 'tunggakan']);
    Route::resource('datausaha', DataUsahaController::class);
});

Route::middleware('ceklogin:tarif')->group(function(){
    Route::get('utilities/tarif', [TarifController::class, 'index']);
    Route::get('utilities/tarif/keamananipk', [TarifController::class, 'keamananipk']);
    Route::get('utilities/tarif/kebersihan', [TarifController::class, 'kebersihan']);
    Route::get('utilities/tarif/airkotor', [TarifController::class, 'airkotor']);
    Route::get('utilities/tarif/lain', [TarifController::class, 'lain']);
    Route::post('utilities/tarif/store', [TarifController::class, 'store']);
    Route::get('utilities/tarif/edit/{fasilitas}/{id}', [TarifController::class, 'edit']);
    Route::post('utilities/tarif/update', [TarifController::class, 'update']);
    Route::get('utilities/tarif/destroy/{fasilitas}/{id}', [TarifController::class, 'destroy']);
});

Route::middleware('ceklogin:alatmeter')->group(function(){
    Route::get('utilities/alatmeter', [AlatController::class, 'index']);
    Route::get('utilities/alatmeter/air', [AlatController::class, 'air']);
    Route::post('utilities/alatmeter/store', [AlatController::class, 'store']);
    Route::get('utilities/alatmeter/edit/{fasilitas}/{id}', [AlatController::class, 'edit']);
    Route::post('utilities/alatmeter/update', [AlatController::class, 'update']);
    Route::get('utilities/alatmeter/destroy/{fasilitas}/{id}', [AlatController::class, 'destroy']);
    Route::get('utilities/alatmeter/qr/{fasilitas}/{id}', [AlatController::class, 'qr']);
});

Route::middleware('ceklogin:harilibur')->group(function(){
    Route::get('utilities/harilibur', [HariLiburController::class, 'index']);
    Route::post('utilities/harilibur/store', [HariLiburController::class, 'store']);
    Route::get('utilities/harilibur/edit/{id}', [HariLiburController::class, 'edit']);
    Route::post('utilities/harilibur/update', [HariLiburController::class, 'update']);
    Route::get('utilities/harilibur/destroy/{id}', [HariLiburController::class, 'destroy']);
});

Route::middleware('ceklogin:blok')->group(function(){
    Route::get('utilities/blok', [BlokController::class, 'index']);
    Route::post('utilities/blok/store', [BlokController::class, 'store']);
    Route::get('utilities/blok/edit/{id}', [BlokController::class, 'edit']);
    Route::post('utilities/blok/update', [BlokController::class, 'update']);
    Route::get('utilities/blok/destroy/{id}', [BlokController::class, 'destroy']);
});

Route::middleware('ceklogin:simulasi')->group(function(){
    Route::get('utilities/simulasi', [SimulasiController::class, 'index']);
    Route::post('utilities/simulasi', [SimulasiController::class, 'store']);
});

Route::middleware('ceklogin:master')->group(function(){
    Route::get('master/kasir/sisa',[MasterController::class, 'getsisa']);

    Route::get('master/kasir/harian/data/perkiraan',[MasterController::class, 'dataPerkiraan']);
    Route::get('master/kasir/harian/data/perkiraan/destroy/{id}',[MasterController::class, 'dataPerkiraanDestroy']);

    Route::get('master/kasir', [MasterController::class, 'kasir']);
    Route::post('master/kasir/restore/{id}', [MasterController::class, 'kasirRestore']);
    Route::post('master/kasir/edit', [MasterController::class, 'kasirEdit']);
    Route::get('master/kasir/struk/{struk}/{id}',[MasterController::class, 'cetakStruk']);
});

Route::middleware('ceklogin:user')->group(function(){
    Route::post('user/update', [UserController::class, 'update']);
    Route::get('user/destroy/{id}', [UserController::class, 'destroy']);
    Route::post('user/reset/{id}', [UserController::class, 'reset']);
    Route::get('user/{id}/otoritas', [UserController::class, 'etoritas']);
    Route::post('user/otoritas', [UserController::class, 'otoritas']);
    Route::get('user/manajer', [UserController::class, 'manajer']);
    Route::get('user/keuangan', [UserController::class, 'keuangan']);
    Route::get('user/kasir', [UserController::class, 'kasir']);
    Route::get('user/nasabah', [UserController::class, 'nasabah']);
    Route::resource('user', UserController::class);
});

Route::middleware('ceklogin:log')->group(function(){
    Route::get('log',function(Request $request){
        if($request->ajax())
        {
            $data = LoginLog::orderBy('id','desc');
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('ktp', function ($ktp) {
                        if ($ktp->ktp == NULL) return '<span class="text-center"><i class="fas fa-times fa-sm"></i></span>';
                        else return $ktp->ktp;
                    })
                    ->editColumn('hp', function ($hp) {
                        if ($hp->hp == NULL) return '<span class="text-center"><i class="fas fa-times fa-sm"></i></span>';
                        else return $hp->hp;
                    })
                    ->editColumn('created_at', function ($user) {
                        return [
                           'display' => $user->created_at->format('d-m-Y H:i:s'),
                           'timestamp' => $user->created_at->timestamp
                        ];
                     })
                    ->rawColumns(['ktp','hp'])
                    ->make(true);
        }
        return view('log.index');
    })->middleware('log');
});

Route::middleware('ceklogin:human')->group(function(){
    Route::get('cari/blok',[SearchController::class, 'cariBlok']);
    Route::get('cari/nasabah',[SearchController::class, 'cariNasabah']);
    Route::get('cari/alamat',[SearchController::class, 'cariAlamat']);
    Route::get('cari/alamat/kosong',[SearchController::class, 'cariAlamatKosong']);
    Route::get('cari/alatlistrik',[SearchController::class, 'cariAlatListrik']);
    Route::get('cari/alatair',[SearchController::class, 'cariAlatAir']);
    Route::get('cari/tagihan/{id}',[SearchController::class, 'cariTagihan']);
    Route::get('cari/listrik/{id}',[SearchController::class, 'cariListrik']);
    Route::get('cari/airbersih/{id}',[SearchController::class, 'cariAirBersih']);
    Route::get('cari/keamananipk/{id}',[SearchController::class, 'cariKeamananIpk']);
    Route::get('cari/kebersihan/{id}',[SearchController::class, 'cariKebersihan']);
    Route::get('cari/airkotor/{id}',[SearchController::class, 'cariAirKotor']);
    Route::get('cari/lain/{id}',[SearchController::class, 'cariLain']);
    Route::get('cari/tagihan/{fasilitas}/{kontrol}',[SearchController::class, 'cariTagihanku']);
});

Route::get('work',[WorkController::class, 'work']);
Route::post('work/update',[WorkController::class, 'update']);

Route::get('download',[DownloadController::class, 'index']);

Route::get('optimize.p3cmaster',function(){
    Artisan::call('optimize');
    Artisan::call('cron:log');
    Artisan::call('cron:login');
    return view('danger');
});