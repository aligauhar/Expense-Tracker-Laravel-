<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function index2()
    {
        return view('home');
    }
    public function about()
    {
        return view('about');
    }
    public function add()
    {
        return view('add');
    }
    public function dashboard()
    {
        return view('dashboard');
    }

    public function register()
    {
        return view('register');
    }
    public function setting()
    {
        return view('setting');
    }
    public function login()
    {
        return view('login');
    }

    public function register2(Request $req)
    {
        $user = new User;
        $user->timestamps = false;
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password')); // Hash the password
        $user->save();
        $req->session()->flash('success', 'Registration successful');
        return redirect('home');
    }
 
public function login2(Request $req)
{
    $username = $req->input('username');
    $password = $req->input('password');

    $user = User::where('name', $username)->first();

    if ($user && Hash::check($password, $user->password)) {
        $userId = $user->id;
        $req->session()->put('id', $userId);
        $req->session()->flash('ssuccess', 'Login successful');
        return redirect('add');
    }

    $req->session()->flash('unsuccess', 'Name or Password incorrect');
        return redirect('login');
}


     public function productadd(Request $req)
     {
         $userId = $req->session()->get('id'); // Retrieve the user ID from the session
         
         $data = new Product;
         $data->timestamps = false;
         $data->userid = $userId;
         $data->name = $req->input('productname');
         $data->price = $req->input('productprice');
         $data->paymenttype = $req->input('paymenttype');
         $data->category = $req->input('productcategory');
         $data->save();
         $req->session()->flash('success', 'Record Added Success');
         return redirect('add');
     }




     public function setExpenseLimit(Request $request)
     {
         // Check if user ID exists in the session
         if (!$request->session()->has('id')) {
             return response()->json(['message' => 'User not authenticated.']);
         }
     
         $userId = $request->session()->get('id');
         $expenseLimit = $request->input('expenseLimit');
     
         // Store the expense limit in the database for the user
         // Example: DB::table('users')->where('id', $userId)->update(['expense_limit' => $expenseLimit]);
     
         // Calculate the total expenses for the current month
         $startDate = now()->startOfMonth()->format('Y-m-d H:i:s');
         $endDate = now()->endOfMonth()->format('Y-m-d H:i:s');
         $totalExpenses = DB::table('products')
             ->where('userid', $userId)
             ->whereRaw("DATE(`date`) BETWEEN '$startDate' AND '$endDate'")
             ->sum('price');
     
         $message = $totalExpenses > $expenseLimit ? 'Maximum limit reached!' : 'Maximum limit not reached!';
         $messageColor = $totalExpenses > $expenseLimit ? 'red' : 'green';
     
         return response()->json(['message' => $message, 'color' => $messageColor]);
     }
 



public function generateReport(Request $request)
{
    $timeframe = $request->query('timeframe');
    $userId = $request->session()->get('id');

    // Calculate the start and end dates based on the selected timeframe
    $startDate = null;
    $endDate = null;

    if ($timeframe === 'daily') {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    } elseif ($timeframe === 'weekly') {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
    } elseif ($timeframe === 'monthly') {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    }

    // Retrieve the categories and expenses from the database based on the user ID and timeframe
    $categories = DB::table('products')
        ->where('userid', $userId)
        ->whereBetween('date', [$startDate, $endDate])
        ->select('category')
        ->distinct()
        ->get();

    $expenses = DB::table('products')
        ->where('userid', $userId)
        ->whereBetween('date', [$startDate, $endDate])
        ->select('category', 'name', 'price')
        ->get();

    // Group the expenses by category
    $groupedExpenses = $expenses->groupBy('category');

    // Generate the report HTML
    $reportData = '<table>';
    $reportData .= '<thead><tr><th>Category</th><th>Product</th><th>Price</th></tr></thead>';
    $reportData .= '<tbody>';

    $grandTotal = 0;

    foreach ($categories as $category) {
        $reportData .= '<tr><td colspan="3"><strong>' . $category->category . '</strong></td></tr>';

        if ($groupedExpenses->has($category->category)) {
            $categoryExpenses = $groupedExpenses[$category->category];

            foreach ($categoryExpenses as $expense) {
                $reportData .= '<tr>';
                $reportData .= '<td></td>';
                $reportData .= '<td>' . $expense->name . '</td>';
                $reportData .= '<td>' . $expense->price . '</td>';
                $reportData .= '</tr>';
            }

            // Calculate the total expenses for the current category
            $categoryTotal = $categoryExpenses->sum('price');
            $reportData .= '<tr><td colspan="2"><strong>Total</strong></td><td>' . $categoryTotal . '</td></tr>';

            // Add the category total to the grand total
            $grandTotal += $categoryTotal;
        }
    }

    // Add the grand total row
    $reportData .= '<tr><td colspan="2"><strong>Grand Total</strong></td><td>' . $grandTotal . '</td></tr>';

    $reportData .= '</tbody>';
    $reportData .= '</table>';

    // Return the response with the report data
    return response()->json(['reportData' => $reportData]);
}



public function logout(Request $request)
    {
        $request->session()->forget('id'); // Remove the 'id' from the session
        $request->session()->regenerate(); // Regenerate the session ID

        return redirect('/home'); // Redirect to the home page or any desired page
    }

}
