<?php

namespace App\Http\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hashids = new Hashids('friend-qr-salt', 10);
        $hashedId = $hashids->encode($user->id);

        // Generate a signed URL
        $url = URL::temporarySignedRoute(
            'addFriendFromQr',
            now()->addHours(24),
            ['user' => $hashedId]
        );

        // Create a new builder instance
        $builder = new Builder(
            writer: new PngWriter(),
            data: $url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 200,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        // Build the QR code
        $result = $builder->build();

        // Get the data URI
        $qrCodeDataUri = $result->getDataUri();

        // Fetch user data
        $users = User::latest()->paginate(10);
        $totalUsers = User::count();
        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard', compact('users', 'totalUsers', 'recentUsers', 'qrCodeDataUri'));
    }
}
