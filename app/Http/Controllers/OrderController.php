<?php

namespace App\Http\Controllers;

use App\Models\Event; // ambil model event
use App\Models\Order; //ambil model order
use App\Models\OrderDetail; // ambil model orderdetail
use Illuminate\Http\Request;//ambil class request
use Illuminate\Support\Facades\DB; // ambil DB untuk urusan transaksi database

class OrderController extends Controller //membuat class orderController
{
    /**
     * Display a listing of the resource.
     */
    public function index() // fungsi untuk menampilkan daftar event ke pelanggan
    {
        $events = Event::all(); // ambil semua event dari database
        return view('customer.index', compact('events')); //tampilkan halaman daftar menu pelanggan
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // fungsi untuk simpan pembelian pelanggan
    {
        $request->validate([ // validasi input  dari form
            'customer_name' => 'required|string|max:255', // nama wajib, teks, maks 255 huruf
            'customer_email'=> 'required|string', // email wajib, teks
            'items'         => 'required|array', // items wajib ada, bentuknya array
            'items.*'       => 'nullable|integer|min:0', //tiap item boleh kosong, angka, min 0
        ]);

        $orderedItems = array_filter($request->items, fn ($qty) => $qty > 0); //ambil cuma item yang jumlahnya lebih dari 0

        if (empty($orderedItems)) { // kalau tidak ada item yang dibeli
            return back()->with('error', 'Pilih minimal satu tiket!'); // balik ke form + pesan error
        }

        //transaction agar data konsisten, kalau error bisa rollback
        DB::beginTransaction(); // mulai transaksi database (semua perintah dianggap satu paket)
        try { 
            $order = Order::create([ // buat pesanan baru
                'customer_name' => $request->customer_name, // simpan nama pembeli
                'customer_email'=> $request->customer_email, // simpan email pembeli
                'total_price'   => 0, // sementara 0, nanti dihitung
                'status'        => 'Pending', // status awal "pending"
            ]);

            $totalPrice = 0; // siapkan wadah total harga

            foreach ($orderedItems as $eventId => $quantity) { // ulangi untuk setiap event yang dibeli
                $event = Event::findOrFail($eventId); // cari event berdasarkan ID
                $subtotal = $event->ticket_price * $quantity; // hitung harga x jumlah
                $totalPrice += $subtotal; // tambahkan ke total

                OrderDetail::create([ // simpan rincian pembelian
                    'order_id' => $order->id, // sambungkan ke pembelian induk
                    'event_id' => $event->id, // simpan ID event
                    'quantity' => $quantity, // simpan jumlah 
                    'subtotal' => $subtotal, // disimpan ke kolom subtotal
                ]);
            }

            $order->update(['total_price' => $totalPrice]); // update total harga pembelian
            DB::commit(); // kalau semua sukses, kunci transaksi

            // bslik ke halaman menu + pesan sukses
            return redirect()->route('customer.index')->with('success', 'Pesanan tiket berhasil!' , number_format($event->ticket_price));
        } catch (\Exception $e) { // kalau ada error di tengah jalan
            DB::rollBack(); // batalkan semua perubahan datbase
            return back()->with('error', 'Gagal memproses pesanan: ' . $e->getMessage()); // balik ke form + pesan error
        }
    }

    /**
     * Display the specified resource.
     */
    public function adminDashboard() // fungsi untuk tampilkan daftar pembelian ke admin
    {
        $orders = Order::with('orderDetails.event')->latest()->get(); // ambil semua pesanan sekalian ambil rincian dan eventnya
        return view('dashboard', compact('orders')); // tampilkan halaman dashboard admin
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id) // fungsi untuk ubah status pesanan
    {
        $order = Order::findOrFail($id); // cari pesanan berdasarkan ID
        $order->update(['status' => $request->status]); // untuk update statusnya
        return back()->with('success', 'Status pesanan #' . $order->id . ' Berhasil diperbarui!'); // balik ke halaman sebelumnya dan pesanan sukses
    }
}
