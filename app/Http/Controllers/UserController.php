<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
    $users = User::all(); // o usa paginate(10) para paginación

    return response()->json($users);
}
}
