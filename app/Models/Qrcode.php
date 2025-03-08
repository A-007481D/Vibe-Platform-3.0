<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Endroid\QrCode\Writer\PngWriter;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'token',
        'expires_at',
        'accepted',
        'qr_code',
    ];

    protected $dates = ['expires_at'];  // Indique que expires_at est un champ de type date
}
