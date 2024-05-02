<?php

namespace App\Http\Controllers\Api;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    //show
    public function show()
    {
        $company = Company::find(1);
        return response(['company' => $company], 200);
    }
}
