<?php

namespace App\Http\Controllers;

use App\Models\Appoinment;
use App\Models\Lab;
use App\Models\Medicine;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Notifications\ReceiptNotification;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Http;



class TicketDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketDetail  $ticket_details
     * @return \Illuminate\Http\Response
     */
    public function show(TicketDetail $ticket_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketDetail  $ticket_details
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketDetail $ticket_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketDetail  $ticket_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketDetail $ticket_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketDetail  $ticket_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketDetail $ticket_details)
    {
        //
    }
    public function ticketEntries()
    {
        $tickets = Appoinment::with('patient', 'doctor')->orderBy('id', 'DESC')->get();
        $medicines = Medicine::get();
        $labs = Lab::get();
        return view('admin.entries', ['tickets' => $tickets, 'medicines'=> $medicines, 'lab_tests'=>$labs]);
    }
    public function ticketDetail($id)
    {
        $ticket = Appoinment::with('patient', 'doctor', 'medicines', 'labTests', 'clinicNotes', 'prescriptions')->find($id);
        
        return view('admin.ticketDetail', ['appointment' => $ticket]);
    }
    public function exportTickets(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'nullable|date|before_or_equal:to_date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'type' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('errors', $validator->errors());
        }
        $tickets = Ticket::query();
        if ($request->from_date) {
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            $tickets = $tickets->whereBetween('created_at', [$from_date, $to_date]);
        }
        if ($request->type) {
            $tickets = $tickets->where('type', $request->type);
        }
        $tickets = $tickets->get();
        $ticketDetails = [];
        $ticketDetails[] = ["Series Number", "Ticket No", "First Name", "Last Name", "Email", "Phone Number", "Address", "Type", "Dietary Requirements", "No. of Child", "Discount", "Amount", "Transaction ID", "Card Type", "Card Number", "Booking Date", "Status"];
        foreach ($tickets as $index => $ticket) {
            $ticketDetails[] = [
                $index + 1,
                $ticket->serial_number ?? $ticket->id,
                $ticket->first_name,
                $ticket->last_name,
                $ticket->email,
                $ticket->phone,
                $ticket->address,
                $ticket->type,
                $ticket->dietary_requiements,
                $ticket->ticket_details->count(),
                $ticket->discount,
                $ticket->total_amount,
                $ticket->transaction_id,
                $ticket->card_brand,
                'XXXXXXXXXXXX' . $ticket->last4,
                $ticket->created_at,
                $ticket->status,
            ];
        }
        $fileName = 'clover-united-soccerthon' . date('d-m-Y') . '.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        );
        return response()->stream(function () use ($ticketDetails) {
            $file = fopen('php://output', 'w');
            foreach ($ticketDetails as $line) {
                fputcsv($file, $line);
            }
            fclose($file);
        }, 200, $headers);
    }
    public function pdfTickets($id)
    {
        $ticket = Ticket::with('ticket_details', 'installments')->find($id);
        // $ticketNumbers = [];
        // foreach ($tickets->ticket_details as $ticketNumber) {
        //     array_push($ticketNumbers, $ticketNumber->ticket_number);
        // }
        // $ticketNumbers = implode(',', $ticketNumbers);
        // $data["title"] = "Naomh Columba Draw | Ticket Number :" . $ticketNumbers;
        $data["ticketData"] = $ticket;
        // $data["ticketNumbers"] = $ticketNumbers;
        $data['ticket'] = $ticket;
        $pdf = PDF::loadView('pdfmail', $data);
        return $pdf->download('tickets.pdf');
    }
    public function export()
    {
        return view('admin.export');
    }

    public function resendEmail(Request $request)
    {
        $request->validate([
            'ticketId' => 'required|exists:tickets,id',
        ]);
        $ticket = Ticket::findOrFail($request->ticketId);

        try {

            $receipt = $request->ticketType;
            if($receipt == 'dinnerDanceReceipt' ) {
                $ticket_numbers = implode(',', Ticket::where('transaction_id',$ticket->transaction_id)->pluck('serial_number')->toArray());
                $ticket->total_amount = Ticket::where('transaction_id',$ticket->transaction_id)->sum('total_amount');
                $ticket->serial_number = $ticket_numbers;
                $subject = 'Dinner Dance Receipt';
            }
            if (App::environment(['staging', 'local'])) {
                FacadesNotification::route('mail', 'atasam.imtiaz@moebotech.com')->notify(new ReceiptNotification($ticket, Null,Null,$receipt));
                FacadesNotification::route('mail', $ticket->email)->notify(new ReceiptNotification($ticket, Null,$subject ?? 'Registration Receipt',$receipt));
            } elseif (App::environment('production')) {
                FacadesNotification::route('mail', 'hello@cloverunited.ie')->notify(new ReceiptNotification($ticket, Null,Null,$receipt));
                FacadesNotification::route('mail', 'saqib.umair@moebotech.com')->notify(new ReceiptNotification($ticket, Null,Null,$receipt));
                FacadesNotification::route('mail', 'ronanweldon@gmail.com')->notify(new ReceiptNotification($ticket, Null,Null,$receipt));
                FacadesNotification::route('mail', 'Mauricemch@gmail.com')->notify(new ReceiptNotification($ticket, Null,Null,$receipt));
                FacadesNotification::route('mail', $ticket->email)->notify(new ReceiptNotification($ticket, Null,$subject ?? 'Registration Receipt',$receipt));
            }
            // FacadesNotification::route('mail', 'atasam.imtiaz@moebotech.com')->notify(new ReceiptNotification($ticket, $receipt));

            return response()->json([
                'success' => true,
                'message' => 'Email has been successfully resent'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend email. Please try again later.'
            ], 500);
        }
    }
}
