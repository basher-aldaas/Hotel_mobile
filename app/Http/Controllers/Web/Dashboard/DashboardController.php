<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // تأكد من أن المستخدم مسجل دخول
    }

    public function index()
    {
        return view('dashboard');
    }}
