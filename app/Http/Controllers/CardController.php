<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Http\Resources\Card as CardResource;
use App\Http\Resources\CardCollection;
use App\Http\Requests\CardRequest;
use App\Helper\Helper;

class CardController extends Controller
{
    public function index()
    {
        $cards = Card::all();

        return new CardCollection($cards);
    }

    public function create()
    {
        // As we are using Vue for frontend, no need of returning the view to create-card the form 
    }

    public function store(CardRequest $request)
    {
        $card = Card::create([
            'number' => Helper::set_number_format($request->number),
            'cvv' => $request->cvv,
            'type' => Helper::check_card_type($request->number[0]),
            'owner' => $request->owner,
            'expiration_date' => $request->expiration_date,
            'is_valid' => Helper::is_valid($request->number)
        ]);

        return response($card, 201);
    }

    public function show(Card $card)
    {
        return new CardResource($card);
    }

    public function edit(Card $card)
    {
        // As we are using Vue for frontend, no need of returning the view to edit-card the form 
    }

    public function update(CardRequest $request, Card $card)
    {
        $card->update([
            'number' => Helper::set_number_format($request->number),
            'cvv' => $request->cvv,
            'type' => Helper::check_card_type($request->number[0]),
            'owner' => $request->owner,
            'expiration_date' => $request->expiration_date,
            'is_valid' => Helper::is_valid($request->number)
        ]);

		return response($card, 202);
    }

    public function destroy(Card $card)
    {
        $card->delete();

		return response('Deleted', 204);
    }

    public function filter($filter)
    {
        $filtered_cards = Helper::fetch_filtered_cards($filter);

        return new CardCollection($filtered_cards);
    }
}
