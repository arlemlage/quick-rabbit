<?php
/*
  ##############################################################################
  # AI Powered Customer Support Portal and Knowledgebase System
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is Paypal Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\RecurringPaymentDate;
use App\Model\Ticket;
use App\Model\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    /**
     * create transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTransaction()
    {
        $ticket_info = Ticket::findOrFail(Session::get('ticket_id'));
        return view('payment.select_payment_method',compact('ticket_info'));
    }

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request, $ticket_id)
    {
        
        $payment = RecurringPaymentDate::find(encrypt_decrypt($ticket_id,'decrypt'));
        if(!$payment){
            $ticket_info = Ticket::findOrFail(encrypt_decrypt($ticket_id,'decrypt'));
        }
        Session::put('ticket_id',encrypt_decrypt($ticket_id,'decrypt'));
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $payment->payment_amount ?? $ticket_info->amount
                    ]
                ]
            ]
        ]);
        
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()->route('select-payment-method',$ticket_id)->with('error', 'Something went wrong.');

        } else {
            return redirect()->route('select-payment-method',$ticket_id)->with('error', $response['message'] ?? 'Something went wrong');
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $status = $response['status'];
            $purches_units = $response['purchase_units'];
            foreach ($purches_units as $purches_unit) {
                $payment_result = $purches_unit['payments']['captures'];
                foreach ($payment_result as $payment){
                    $tran_id = $payment['id'];
                    $tran_amount = $payment['amount']['value'];

                    $identify = [
                        'ticket_id' => Session::get('ticket_id'),
                        'customer_id' => Auth::id()
                    ];
                    $data = [
                        'ticket_id' => Session::get('ticket_id'),
                        'customer_id' => Auth::id(),
                        'payment_method' => "paypal",
                        'transaction_id' => $tran_id,
                        'payment_amount' => $tran_amount,
                        'currency' => $payment['amount']['currency_code'],
                        'transaction_time' => Carbon::now(),
                        'payment_status' => "Paid",
                        'transaction_status' => $status
                    ];
                    Transaction::updateOrInsert($identify,$data);

                    Ticket::find(Session::get('ticket_id'))->update(['payment_status' => 'Paid']);
                }
            }
            return redirect()
                ->route('payment-history')
                ->with('message', 'Payment Successfull');
        } else {
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('dashboard')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
