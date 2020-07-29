<?php

namespace App\Http\Controllers;

use App\Services\CardService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * The homepage.
     *
     * @method GET
     * @param  CardService $cardService
     * @return Renderable
     */
    public function index(CardService $cardService)
    {
        $cards = $cardService->findAll();
        return view('welcome', compact('cards'));
    }
}
