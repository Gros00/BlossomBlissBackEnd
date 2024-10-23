<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function create(Request $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        } else {
            return response()->json([
                'message' => 'Файл изображения не был отправлен',
            ], 400);
        }
        $to = trim($request['to'],'"');
        $type = trim($request['type'],'"');
        // Создание новой записи в базе данных
        $card = Cards::create([
            'title' => $request['title'],
            'to' => $to,
            'type' => $type,
            'rating' => $request['rating'],
            'image' => $imagePath,
            'cost'=>$request['cost'],
        ]);

        // Ответ на запрос с сообщением об успешном создании
        return response()->json([
            'message' => 'Карточка успешно создана.',
            'card' => $card, // Можно добавить информацию о созданной карточке, если нужно
        ], 201);
    }

    public function getCards()
    {
        $cards = Cards::all();
        return response()->json($cards);
    }

    public function updateCard(Request $request, $id)
    {
        $card = Cards::find($id);

        if (!$card) {
            return response()->json([
                'message' => 'Карточка не найдена.',
            ], 404);
        }

        $card->update($request->all());

        return response()->json([
            'message' => 'Карточка успешно обновлена.',
            'card' => $card,
        ], 200);
    }

    public function deleteCard($id)
    {
        $card = Cards::find($id);

        if (!$card) {
            return response()->json([
                'message' => 'Карточка не найдена.',
            ], 404);
        }

        $card->delete();

        return response()->json([
            'message' => 'Карточка успешно удалена.',
        ], 200);
    }

    public function mostValuable(){
        $cards = Cards::orderBy('rating', 'desc')->take(4)->get();

        return response()->json([$cards]);
    }
}
