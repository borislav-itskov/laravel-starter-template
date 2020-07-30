<?php

namespace App\Http\Controllers;

use App\Services\CardService;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Create a card view
     *
     * @method GET
     * @return Illuminate\Contracts\Support\Renderable
     */
    public function create(CardService $cardService)
    {
        $types = $cardService->getTypes();
        return view('create', $types);
    }

    /**
     * Create a card route
     *
     * @method POST
     * @return Illuminate\Support\Facades\Redirect
     */
    public function store()
    {
        # code...
    }
}
