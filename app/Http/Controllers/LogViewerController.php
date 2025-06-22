<?php

namespace App\Http\Controllers;

use App\Models\Log as LogModel;

class LogViewerController extends Controller
{
    public function index()
    {
        $logs = LogModel::latest()->paginate(20);

        return view('logs.index', compact('logs'));
    }
}
