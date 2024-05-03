<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchCustomerController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve the search keyword from the query string
        $keyword = $request->query('keyword');

        // Perform the search query if keyword is provided
        if ($keyword) {
            $customers = User::where('role', 'Customer')
                ->where('nama', 'like', '%' . $keyword . '%')
                ->latest()
                ->paginate(5);
        } else {
            // Otherwise, fetch all customers
            $customers = User::where('role', 'Customer')->latest()->paginate(5);
        }

        return view('viewAdmin.SearchCustomer.index', compact('customers', 'keyword'));
    }
    
    public function show($id)
    {
        $customers = User::findOrFail($id);
        $history = History::where('id_user', $id)->get();

        return view('viewAdmin.SearchCustomer.show', compact('customers', 'history'));
    }
}
