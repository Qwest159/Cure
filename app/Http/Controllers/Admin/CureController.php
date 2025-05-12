<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Cure;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Cure::class);
        return Inertia::render('Admin/Cure');
    }
}
