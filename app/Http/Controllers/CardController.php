<?php

namespace App\Http\Controllers;

use App\Features\Cards\CardDirector;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Create a card route
     *
     * @method POST
     * @return Illuminate\Support\Facades\Redirect
     */
    public function store(Request $request, CardDirector $cardDirector)
    {
        $data = $request->all();
        $cardBuilder = $cardDirector->getBuilder($data['type']);
        return $cardBuilder->create($data);
    }
}
