<?php

namespace App\Http\Controllers;

use App\Models\Appoinment;
use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_orders = 0;

        if (Auth::check() && Auth::user()->role === 'doctor') {
            $total_orders = Appoinment::where('doctor_id', Auth::user()->id)->count();
        }else{
            $total_orders = Appoinment::count();            
        }
        $total_amount = Appoinment::sum('amount');

        return view('home', ['total_orders' => $total_orders, 'total_amount' => $total_amount]);
    }
}
