<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QrController extends Controller
{
    // Générer l'invitation et le QR code
    public function generate()
    {
        $user = Auth::user(); // L'utilisateur actuel

        // Générer un token unique
        do {
            $token = Str::random(60);  // Utiliser Str::random() au lieu de str_random()
        } while (Qrcode::where('token', $token)->exists());  // Vérifie si le token existe déjà
        
        $qrcode = Qrcode::create([
            'sender_id' => $user->id,
            'token' => $token,
            'expires_at' => Carbon::now()->addHour()->toDateTimeString(),
            'accepted' => false,
        ]);        

        // Générer le lien d'invitation
        $url = route('invitation.accept', ['token' => $token]);

        // Générer le QR code
        $qrCode = new QrCode($url);
        $qrCode->setSize(200);
        $qrCode->setMargin(10);
        $qrCode->setEncoding('UTF-8');

        // Sauvegarder l'image QR code
        $writer = new PngWriter();
        $qrImage = $writer->write($qrCode)->getData()->getUri();

        // Mettre à jour l'entrée de la table qrcode avec le QR code généré
        $qrcode->update(['qr_code' => $qrImage]);

        return view('qrcode.generate', compact('qrcode', 'qrImage'));
    }

    // Accepter l'invitation
    public function accept($token)
    {
        // Vérifier si l'invitation existe et est valide
        $qrcode = Qrcode::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$qrcode) {
            return redirect()->route('home')->with('error', 'Invitation invalide ou expirée');
        }

        // Marquer l'invitation comme acceptée
        $qrcode->update(['accepted' => true]);

        // Ajouter la logique pour l'ajout à l'ami, etc.

        return redirect()->route('home')->with('success', 'Invitation acceptée');
    }
}
