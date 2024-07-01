<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function create(Request $request)
    {
        $karyawan = new Karyawan();

        $karyawan->name = $request->input('name');
        $karyawan->address = $request->input('address');
        $karyawan->phone = $request->input('phone');
        
        $karyawan->save();
        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        $karyawan->name = $request->input('name');
        $karyawan->address = $request->input('address');
        $karyawan->phone = $request->input('phone');

        $karyawan->save();
        return response()->json($karyawan);
    }

    public function delete(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        $karyawan->delete();
        return response()->json($karyawan);
    }
}
