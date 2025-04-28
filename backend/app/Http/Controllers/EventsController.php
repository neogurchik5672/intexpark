<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Events;

class EventsController extends Controller
{
    public function index() {
        $query = Events::query()->get();
        return view('events.index', compact('query'));
    }
}
