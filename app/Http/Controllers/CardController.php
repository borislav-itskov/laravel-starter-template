<?php

namespace App\Http\Controllers;

use App\Formatters\CardFormatter;
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
    public function create(
        CardService $cardService,
        CardFormatter $cardFormatter
    )
    {
        $types = $cardService->getTypes();
        $fields = $cardFormatter->getFormFields($types);
        return view('create', compact('types', 'fields'));
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
