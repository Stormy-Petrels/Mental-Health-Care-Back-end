<?php

namespace  App\Http\Controllers\Patient;

use App\Dtos\Patient\AppoinmentReq;
use App\Http\Controllers\Controller;
use App\Models\Appoinment;
use App\Repositories\AppoinmentsRepository;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private AppoinmentsRepository $appoinmentRepository;

    public function __construct()
    {
        $this->appoinmentRepository = new AppoinmentsRepository();
    }
    public function makePayment(Request $request)
    {
        $data = $request->all();
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/";
        $vnp_TmnCode = "76FGSU2B"; //Mã website tại VNPAY
        $vnp_HashSecret = "H0BXRQ999RXBH7EX0CUDFYFAJJ0S5FC6"; //Chuỗi bí mật

        $vnp_TxnRef = rand(1, 999999) . rand(0, 99999) . 'CF'; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toan hoa don";
        $vnp_OrderType = "grocerymart coffee shop";
        $vnp_Amount = $data['total'] * 1000;
        $vnp_Locale = 'VN';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        // Instead of returning a view, return JSON response
        return response()->json([
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        ]);
    }

    public function storePaymenttofVNPAY(AppoinmentReq $req) {
        if ($req->CalendarId == "") {
            return response()->json([
                'message' => 'Appointment failed',
            ], 404);
        }

        $newBooking = new Appoinment($req->patientId, $req->doctorId, $req->date, $req->CalendarId, $req->status);
        $this->appoinmentRepository->insert($newBooking);

        return response()->json([
            'message' => 'You have successfully booked your appointment',
        ], 200);
        
    }
};
