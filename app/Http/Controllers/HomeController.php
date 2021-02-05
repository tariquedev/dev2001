<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Order;
use Carbon\Carbon;
use App\Exports\OrderExport;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Comment;
use App\Review;
use Auth;

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
        $today = Order::wheredate('created_at', Carbon::now())->count();
        $seven_days_ago = Order::whereDate('created_at', Carbon::now()->subDays(7))->count();
        $yesterday = Order::wheredate('created_at', Carbon::yesterday())->count();
        return view('backend.dashboard',[
            'today' => $today,
            'seven_days_ago' => $seven_days_ago,
            'yesterday' => $yesterday
        ]);
    }

    function users(){
        $user_count = User::count();
        $users = User::orderBy('name', 'asc')->paginate();
        return view('backend.users.users', [
            'users' => $users,
            'user_count' => $user_count
        ]);
    }

    function orders(){

        return view('backend.orders.orders',[
            'orders' => Order::latest()->paginate(10)
        ]);
    }

    function ExcelDownload(){

        return Excel::download(new OrderExport, 'orders.xlsx');
    }

    public function import(Request $request) 
    {
      
        Excel::import(new CategoryImport, $request->file('excel'));
        
        return redirect('/')->with('success', 'All good!');
    }

    function SelectedDateExcelDownload(Request $request){
        $from = $request->start;
        $to = $request->end;

        return Excel::download(new OrderExport($from, $to), 'orders.xlsx');
        
    }

    function PDFDownload(){
        $orders = Order::all();
        $pdf = PDF::loadView('exports.pdf', [
            'orders' => $orders
            ]);
        return $pdf->download('invoice.pdf');
    }

    function Comments(Request $request){
        
        $comments = new Comment;
        $comments->blog_id = $request->blog_id;
        $comments->user_id = Auth::id();
        $comments->name = $request->name;
        $comments->email = $request->email;
        $comments->status = 2;
        $comments->comment = $request->comment;
        $comments->save();

        return back();
    }

    function UserReview(Request $request){

            if (Review::where('user_id', Auth::id())->where('product_id', $request->product_id)->exists()) {
                return 'Vagen';
            }
            else{
                $reviews = new Review;
                $reviews->user_id = Auth::id();
                $reviews->product_id = $request->product_id;
                $reviews->rating = $request->rating;
                $reviews->name = $request->name;
                $reviews->email = $request->email;
                $reviews->massage = $request->massage;
                $reviews->save();

                return back();
            }
            
    }
}
