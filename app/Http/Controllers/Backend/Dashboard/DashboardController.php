<?php

namespace App\Http\Controllers\Backend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function vistaDashboard()
   { 
       return view('backend.admin.dashboard.vistadashboard');
   }   
}
