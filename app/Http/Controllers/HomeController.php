<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request; // ✅ correct use
use Google_Client;
use App\Models\User;
use App\Models\Orders;
use App\Models\Product;
use App\Models\WalletUser;
use App\Mail\OrderPlaced;
use App\Models\Notifications;
use App\Models\NotificationsUsers;
use App\Models\Shops;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function indexEmail()
    {
        $user = (object) [
            'name' => 'John Doe',
            'email' => 'fawad1824@gmail.com',
            'phone' => '+923459242192',
            "password" => "1212",
        ];

        try {
            Mail::to($user->email)->send(new TestEmail(
                $user->name,
                $user->email,
                $user->phone,
                $user->password
            ));
            return response()->json(['message' => '✅ Test email sent successfully!']);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('❌ Email sending failed: ' . $e->getMessage());

            return response()->json([
                'message' => '❌ Failed to send test email.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function FCMstore(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = User::where('id', Auth::user()->id)->first(); // ya anonymous ke liye session ya IP use karein
        $user->fcm_token = $request->token;
        $user->save();

        return response()->json(['message' => 'FCM token saved.']);
    }


    public static function sendNotification($token, $name, $message)
    {
        $credentialsPath = storage_path('app/firebase/fcmJson.json');

        // Initialize Google Client
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];

        // Extract Project ID from your credentials JSON
        $projectId = json_decode(file_get_contents($credentialsPath), true)['project_id'];

        // Build notification payload
        $message = [
            "message" => [
                "token" => $token,
                "notification" => [
                    "title" => "New Message From" . " " . $name,
                    "body" => $message,
                ],
                "data" => [
                    "screen" => "chat",          // Custom key-value pairs
                    "user_id" => "12345",
                    "order_id" => "67890"
                ],
                "android" => [
                    "priority" => "high"
                ]
            ]
        ];


        // Send FCM v1 request
        $response = Http::withToken($accessToken)
            ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $message);

        return response()->json([
            'success' => true,
            'response' => $response->json()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'phone'        => 'required',
            'address'      => 'required|string|max:500',
            'date'         => 'required|date',
            'paymenttype'  => 'required|in:online,cod,wallet',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'note'         => 'nullable|string',
        ]);


        $user = Auth::user();
        $cart = session()->get('cart', []);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found.'], 404);
        }

        $totalAmount = 0;

        if (!empty($cart)) {
            $orderID = 'ORD-' . now()->format('YmdHis') . '-' . rand(100, 999);


            // CART ORDER
            foreach ($cart as $item) {
                $product = Product::where('name', $item['name'])->first();
                $product->stock = $product->stock -  $item['quantity'];
                $product->save();





                if (!$product) {
                    continue; // skip invalid product
                }

                $price = (float)$product->price;
                $qty = (int)$item['quantity'];
                $total = $price * $qty;
                $totalAmount += $total;

                // Wallet check (once)
                if ($request->paymenttype === 'wallet') {
                    $wallet = WalletUser::where('user_id', $user->id)->first();
                    if (!$wallet || $wallet->balance < $totalAmount) {
                        return response()->json(['paymenttype' => 'Insufficient wallet balance.']);
                    }
                }


                $order = new Orders();
                $order->user_id         = $user->id;
                $order->delivery_address = $request->address;
                $order->delivery_date   = $request->date;
                $order->payment_method  = $request->paymenttype;
                $order->product_id      = $product->id;
                $order->price           = (string) $price;
                $order->quantity        = (string) $qty;
                $order->total_amount    = number_format($total, 2, '.', '');
                $order->notes           = $request->note;
                $order->payment_status  = 'unpaid';
                $order->status          = 'pending';
                $order->orderid         = $orderID;
                $order->latitude        = $request->latitude;
                $order->longitude       = $request->longitude;
                $order->shop            = $product->shop;
                $order->p_price         = $product->p_price;
                $order->save();
            }

            $orderList = Orders::where('orderid', $orderID)->get();
            Mail::to($request->email)->send(new OrderPlaced($orderID, $request->full_name, $totalAmount, $orderList));

            session()->forget('cart'); // empty the cart

            return response()->json([
                'status' => 'success',
                'message' => 'Your order has been placed!'
            ]);
        } else {
            // SINGLE PRODUCT ORDER
            $product = Product::find($request->product_id);
            if (!$product) {
                return response()->json(['status' => 'error', 'message' => 'Product not found.'], 404);
            }

            $total = $product->price * $request->quantity;

            if ($request->paymenttype === 'wallet') {
                $wallet = WalletUser::where('user_id', $user->id)->first();
                if (!$wallet || $wallet->balance < $total) {
                    return response()->json(['paymenttype' => 'Insufficient wallet balance.']);
                }
            }

            $product = Product::find($request->product_id);
            $product->stock = $product->stock - $request->quantity;
            $product->save();



            $orderID = 'ORD-' . now()->format('YmdHis') . '-' . rand(100, 999);

            $order = new Orders();
            $order->user_id         = $user->id;
            $order->delivery_address = $request->address;
            $order->delivery_date   = $request->date;
            $order->payment_method  = $request->paymenttype;
            $order->product_id      = $product->id;
            $order->price           = (string) $product->price;
            $order->quantity        = (string) $request->quantity;
            $order->total_amount    = number_format($total, 2, '.', '');
            $order->notes           = $request->note;
            $order->payment_status  = 'unpaid';
            $order->status          = 'pending';
            $order->orderid         = $orderID;
            $order->latitude        = $request->latitude;
            $order->longitude       = $request->longitude;
            $order->shop       = $request->shop;
            $order->p_price         = $product->p_price;
            $order->save();



            $orderList = Orders::where('orderid', $orderID)->get();
            try {
                Mail::to($request->email)->send(new OrderPlaced($orderID, $request->full_name, $totalAmount, $orderList));
            } catch (Exception $e) {
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Your order has been placed!'
            ]);
        }
    }

    public function ShopSave(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'today_rate'    => 'required',
            'time'    => 'required',
        ]);

        $shop = new Shops();
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->phone = $request->phone;
        $shop->whatsapp = $request->whatsapp;
        $shop->lat = $request->latitude;
        $shop->long  = $request->longitude;
        $shop->time  = $request->time;
        $shop->today_rate  = $request->today_rate;
        $shop->save();

        return response()->json(['status' => 'success', 'message' => 'Shop saved successfully!']);
    }

    public function StoreNotifications(Request $request)
    {
        $request->validate([
            'customers' => 'required|array',
            'message' => 'required|string|max:255',
        ]);

        // Save notification logic

        $noti = Notifications::create([
            'message' => $request->message,
        ]);

        foreach ($request->customers as $customerId) {
            NotificationsUsers::create([
                'from_user' => Auth::id(),
                'to_user' => $customerId,
                'notification_id' => $noti->id,
            ]);
        }

        return redirect()->back()->with('success', 'Notification sent!');
    }

    public function GetNotifications()
    {
        $user = User::where('role', 'customer')->get();
        $notifications = Notifications::all();
        return view('livewire.admin.notification.NotificationsSent', [
            'users' => $user,
            'notifications' => $notifications
        ]);
    }

    public function fcmGenerate()
    {
        return view('dummy.dummy');
    }

}
