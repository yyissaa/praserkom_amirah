<?php

namespace App\Http\Controllers; // Menentukan namespace class ini berada di folder App\Http\Controllers

use App\Models\Event; // Import model Food agar bisa dipakai tanpa App\Models\Eveent
use Illuminate\Http\Request; // Import class request untuk menerima input dari form
use Illuminate\Support\Facades\Storage; //Import storage facades

class EventController extends Controller //membuat class eventController
{
    /**
     * Display a listing of the resource.
     */
    public function index() //tampilkan daftar event
    {
        $events = Event::latest()->paginate(10); // Ambil semua event, urutan terbaru, 10 per halaman
        return view('admin.events.index', compact('events')); // tampilkan halaman admin/events/index, bawa data event tadi
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() // tampilkan form tambah event
    {
        return view('admin.events.create'); // tampilkan halaman form tambah
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // simpan event baru ke database
    {
        $request->validate([ // validasi data yang dikirim dari form
            'title'       => 'required|string|max:255', // nama wajib diisi, teks maksimal 255 huruf
            'category'    => 'required|in:Musik,Festival,Seminar', // kategori wajib diisi, hanya bisa diantara 3 pilihan itu
            'ticket_price'=> 'required|numeric|min:0', // price harus diisi, angka bulat, minimal 0
            'description' => 'required|string', // deskripsi hrus diisi
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // foto boleh kosong, format harus diantara 3 itu, maks 2mb
        ]);

        $imagePath = null; // wadah untuk gambar

        if ($request->hasFile('image')) { // kalau user upload gambar
            $imagePath = $request->file('image')->store('events', 'public'); // simpan gambar ke folder events, simpan alamatnya di $imagePath
        }

        Event::create([ // simpan event baru ke database
            'title'       => $request->title, // isi kolom nama
            'category'    => $request->category, //isi kolom kategori
            'ticket_price'=> $request->ticket_price, // isi kolom harga
            'description' => $request->description, //isi kolom deskripsi
            'image'       => $imagePath, //isi kolom image, bisa null
        ]);

        return redirect()->route('events.index') // pindah ke halaman daftar event + pesan berhasil
            ->with('success', 'Data event berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event) // fungsi untuk menampilkan form edit event, $event otomatis dicari laravel berdasarkan ID 
    {
        return view('admin.events.edit', compact('event')); // menampilkan halaman edit sambil bawa data event yang ingin diedit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event) // fungsi untuk simpan perubahan event
    {
        $request->validate([ //validasi data yang dikirim dari form
            'title'       => 'required|string|max:255', // nama wajib diisi, teks maksimal 255 huruf
            'category'    => 'required|in:Musik,Festival,Seminar', // kategori wajib diisi, hanya bisa diantara 3 pilihan itu
            'ticket_price'=> 'required|numeric|min:0', // ticketprice harus diisi, angka bulat, minimal 0
            'description' => 'required|string', // deskripsi harus diisi
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // foto boleh kosong, format harus diantara 3 itu, maks 2mb
        ]);

        $imagePath = $event->image; // simpan dulu gambar lama (jika user tidak ganti gambar)

        if ($request->hasFile('image')) { // kalau user upload gambar baru
            if ($event->image && Storage::disk('public')->exists($event->image)) { // cek dahulugambar lama ada dan filenya benar ada di storage
                Storage::disk('public')->delete($event->image); // hapus gambar lama
            }
            $imagePath = $request->file('image')->store('events', 'public'); // simpan gambar baru
        }

        $event->update([ // update data event
            'title'       => $request->title, //update nama
            'category'    => $request->category, // update kategori
            'ticket_price'=> $request->ticket_price, //update harga
            'description' => $request->description, //update deskripsi
            'image'       => $imagePath, //update gambar(baru atau lama)
        ]);

        return redirect()->route('events.index') // balik ke daftar event + pesan berhasil
            ->with('success', 'Data event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event) // fungsi untnuk hapus data makanan
    {
        if ($event->image && Storage::disk('public')->exists($event->image)) { // cek dahulu gambar ada dan filenya benar ada di storage
            Storage::disk('public')->delete($event->image); // hapus file gambarnya
        }

        $event->delete(); // hapus data event dari database

        return redirect()->route('events.index') // balik ke daftar + pesan berhasil
            ->with('success', 'Data event berhasil dihapus!');
    }
}