<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $menu = "home";
        return view("home", compact("menu"));
    }
    public function profile()
    {
        $menu = "profile";
        return view("profile", compact("menu"));
    }
    public function media()
    {
        $menu = "media";
        return view("media", compact("menu"));
    }
    public function services()
    {
        $menu = "services";
        return view("services", compact("menu"));
    }
    public function transaction()
    {
        $menu = "transaction";
        return view("transaction", compact("menu"));
    }
    public function report()
    {
        $menu = "report";
        return view("report", compact("menu"));
    }
    public function reward()
    {
        return view("reward");
    }
    public function credit()
    {
        return view("credit");
    }
    public function welcome()
    {
        return view("welcome");
    }
    public function mahasiswa()
    {
        return view("mahasiswa");
    }
    public function proses(Request $request)
    {
        $nim = $request->nim;
        $nama = $request->nama;
        $gender = $request->gender;
        $prodi = $request->prodi;
        $pakar = $request->pakar;

        return view("proses", compact("nim", "nama", "gender", "prodi", "pakar"));
    }
}
