<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    public function get_states()
    {
        $states = State::get();

        return response()->json(['message' => 'fetched states', 'data' => $states]);
    }
}
