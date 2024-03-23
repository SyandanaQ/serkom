<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculation;

class CalculatorController extends Controller 
{
    public function calculate(Request $request)
    {
        $operasi = $request->input('operasi');
        $bil_pertama = (int) $request->input('bil_1');
        $bil_kedua = (int) $request->input('bil_2');
        $result = 0;

        if ($operasi == "tambah") {
            $result = $bil_pertama + $bil_kedua;
        } else if ($operasi == "kurang") {
            $result = $bil_pertama - $bil_kedua;
        } else if ($operasi == "bagi") {
            if ($bil_kedua != 0) {
                $result = $bil_pertama / $bil_kedua;
            } else {
                // Penanganan jika pembagian oleh nol terdeteksi
                return response()->json(['error' => 'Pembagian oleh nol tidak diperbolehkan.'], 400);
            }
        } else if ($operasi == "kali") {
            $result = $bil_pertama * $bil_kedua;
        } else if ($operasi == "mod") {
            $result = $bil_pertama % $bil_kedua;
        } else {
            $result = 0;
        }

        // Buat instance baru dari model Calculation dan simpan data
        $calculation = new Calculation;
        $calculation->operation = $operasi;
        $calculation->operand1 = $bil_pertama;
        $calculation->operand2 = $bil_kedua;
        $calculation->result = $result;
        $calculation->save(); // Menyimpan data ke database

        return redirect('/')->with('info', 'Hasilnya adalah: ' . $result);
    }

    public function reuseCalculation($calculationId)
    {
        // Cari perhitungan berdasarkan ID
        $calculation = Calculation::find($calculationId);

        if (!$calculation) {
            return response()->json(['error' => 'Perhitungan tidak ditemukan.'], 404);
        }

        // Gunakan kembali hasil perhitungan
        return redirect('/')->with('info', 'Hasil penggunaan kembali: ' . $calculation->result);
    }

    public function showCalculator()
    {
        $calculations = Calculation::all();
        return view('calculator', compact('calculations'));
    }
}
