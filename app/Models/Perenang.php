<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perenang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'tinggi',
        'berat',
        'panjang_lengan_kiri',
        'panjang_lengan_kanan',
        'panjang_armspan',
        'panjang_kaki',
        'last_prediction_gaya',   
        'last_prediction_jarak',  
        'last_prediction_time', 
        'last_prediction_performance', 
        'last_prediction_percentage',
        'last_prediction_date', 
        'user_id'
    ];

     protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getLabelGayaAttribute()
    {
        switch ($this->last_prediction_gaya) {
            case 'gaya_bebas': return 'Gaya Bebas';
            case 'gaya_dada': return 'Gaya Dada';
            case 'gaya_punggung': return 'Gaya Punggung'; // Pastikan gaya punggung juga ada
            case 'gaya_kupu': return 'Gaya Kupu-kupu';
            case 'gaya_medley': return 'Gaya Medley';
            default: return 'Gaya Tidak Diketahui';
        }
    }

}
