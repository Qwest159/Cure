<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Models\Cure;
use App\Models\Date;
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
        $date_dispo = Date::withCount('chambres')->orderBy('chambres_count')
            ->get();




        return Inertia::render('Admin/Cure', [
            'date_dispo' =>  $date_dispo,
        ]);
    }
}
