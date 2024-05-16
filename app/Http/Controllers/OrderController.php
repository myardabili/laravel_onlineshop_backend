<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class OrderController extends Controller
{
    public function index(Request $resquest) {
        $orders = DB::table('orders')->paginate(10);
        // $orders = \App\Models\Order::paginate(10);
        return view('pages.order.index', compact('orders'));
    }

    public function show($id) {
        return view('orders.show');
    }

    public function edit($id) {
        $order = DB::table('orders')->where('id', $id)->first();
        return view('pages.order.edit', compact('order'));
    }

    public function update(Request $request, $id) {
        $order = DB::table('orders')->where('id', $id);
        $order->update([
            'status' => $request->status,
            'shipping_resi' => $request->shipping_resi,
        ]);

        if($request->status == 'paid') {
            $this->sendNotificationToUser($order->first()->user_id, 'Pembayaran berhasil dilakukan');
        }else if($request->status == 'on_delivery') {
            $this->sendNotificationToUser($order->first()->user_id, 'Paket telah dikirim dengan nomor resi ' . $request->shipping_resi);
        }else if($request->status == 'delivered') {
            $this->sendNotificationToUser($order->first()->user_id, 'Paket telah sampai tujuan');
        }else if($request->status == 'cancelled') {
            $this->sendNotificationToUser($order->first()->user_id, 'Pesanan Anda dibatalkan');
        }elseif($request->status == 'expired') {
            $this->sendNotificationToUser($order->first()->user_id, 'Pesanan Anda telah kedaluwarsa karena telah melewati batas waktu yang ditentukan');
        }

        return redirect()->route('order.index');
    }

    public function sendNotificationToUser($userId, $message) {

        $user = User::find($userId);
        $token = $user->fcm_id;

        $messaging = app('firebase.messaging');
        $notification = Notification::create('Onlineshop Application', $message);

        $message = CloudMessage::withTarget('token', $token)->withNotification($notification);

        $messaging->send($message);
    }
}
