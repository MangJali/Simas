<?php

namespace App\Http\Controllers;

use App\Models\Matapelajaran;
use App\Models\Siswaa;
use App\Models\Tenagapendidik;
use App\Models\Ulanganharian;
use Illuminate\Http\Request;

class UlanganHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == "admin") {
            $nilaiuh = Ulanganharian::all();
        } else {
            $nilaiuh = Ulanganharian::whereHas("mapel", function ($query) {
                $guru = Tenagapendidik::where("userid", auth()->user()->id)->first();
                $query->where("nip", $guru->nip);
            })->get();
            // $nilaitugas->mapel()->wherePivot("nip",$guru->nip)->get();
            // print_r($nilaitugas);
        }
        return view('datanilaisiswa/ulanganharian', compact('nilaiuh'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mapel = Matapelajaran::all();
        $siswa = Siswaa::all();
        $array = [];
        foreach ($siswa as $key => $value) {
            foreach ($mapel as $key1 => $value1) {
                $tugassiswa = Ulanganharian::where(["kodemapel" => $value1->kodemapel, "nis" => $value->nis])->get();
                if (count($tugassiswa) == 0) {
                    $uhbaru = new Ulanganharian();
                    $uhbaru->nis = $value->nis;
                    $uhbaru->kodemapel = $value1->kodemapel;
                    array_push($array, $uhbaru);
                }
            }
        }
        return view('datanilaisiswa/tambahulanganharian', ['uhbaru' => $array]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->nis)) {
            foreach ($request->nis as $key => $value) {
                $nilaiuh = new Ulanganharian;
                $nilaiuh->nis = $value;
                $nilaiuh->kodemapel = $request->kodemapel[$key];
                $nilaiuh->ulanganharian1 = $request->uh1[$key];
                $nilaiuh->Ulanganharian2 = $request->uh2[$key];
                $nilaiuh->save();
            }
        }
        return redirect('datanilaisiswa/ulanganharian')->with('sukses', 'Sukses menambahkan data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uh = Ulanganharian::where("id_uh", $id)->first();
        return view('datanilaisiswa/ubahulanganharian', ["uh" => $uh]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $uh = Ulanganharian::where("id_uh", $id)->first();
        $uh->where("id_uh", $id)->update($request->except(['_token']));
        return redirect('datanilaisiswa/ulanganharian')->with("sukses", "berhasil mengupdate data tugas!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
