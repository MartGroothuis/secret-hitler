<?php

namespace App\Http\Controllers;

use App\Room;
use App\Player;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function data()
    {
        $rooms = Room::all();
        $count = 0;

        foreach ($rooms as $room) {
            $user = User::where('id', $room->user_id)->pluck('name')->first();
            $rooms[$count]['username'] = $user;

            $players = Player::where('room_id', $room->id)->get();
            $rooms[$count]['ammountOfPlayers'] = count($players);

            $count++;
        }

        return $rooms;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $rooms = Room::all();
        return view('lobby', compact('rooms', 'user'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        if (Room::where('user_id',  $user->id)->exists()) { } else {
            $room = Room::create(array_merge($request->all(), ['user_id' => $user->id]));
        }

        return response()->json($room, 200);
    }

    public function show(Room $room)
    {
        $user = Auth::user();

        $player = $user->player;

        $room = Room::find($player->room_id);

        return view('game', compact('room', 'user', 'player'));
    }

    public function update(Request $request, Room $room)
    {
        $room->update($request->all());
        return response()->json($room, 200);
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $room_id = Room::where('user_id', $user->id)->pluck('id')->first();
        Player::where('room_id', $room_id)->delete();
        Room::where('user_id', $user->id)->delete();
        return redirect('/lobby');
    }

    public function destroy()
    {
        Room::truncate();
        return response()->json(null, 204);
    }

    // De functies getPresidentCards tot ... zijn voor het behandelen van de kaarten
    public function getPresidentCards(Request $request)
    {

        $player = $request->user()->player;
        // alleen de huidige president mag kaarten inzien
        if ($player->president) {
            $room = Room::where('id', $player->room_id)->get()->first();

            $drawCards = Room::where('id', $player->room_id)->get();

            $drawCards = json_decode($drawCards[0]->draw_pile);

            // er moeten wel 3 kaarten zijn anders moet er opnieuw geschud worden
            if (count($drawCards) < 3) {
                return 'niet genoeg kaarten';
                $this->shuffleCards($room);
            } else {
                // return $drawCards;
                // dit naar draw pile
                $draw_pile = array_slice($drawCards, 3);
                // eerste 3 kaarten naar card pile en return
                $cards_pile = array_slice($drawCards, 0, 3);

                // return $draw_pile;

                Room::where('id', $player->room_id)->update(['draw_pile' => json_encode($draw_pile), 'cards_pile' => json_encode($cards_pile)]);
                // geef alleen de eerste 3 kaarten naar de preident
                return $cards_pile;
            }
        }
    }

    public function getChancellorCards(Request $request)
    {
        $player = $request->user()->player;
        // alleen de huidige president mag kaarten inzien
        if ($player->chancellor) {

            $array = Room::where('id', $player->room_id)->pluck('draw_pile');

            $input = json_decode($array[0]);
            // geef alleen de eerste 2 kaarten naar de preident
            return array_slice($input, 0, 2);
        }
    }


    public function discardCard(Request $request, $discardCard)
    {
        $player = $request->user()->player;
        // alleen de huidige president mag een kaart verwijderen
        $room = Room::where('id', $player->room_id)->first();

        $cards_pile = $room->cards_pile;
        $discard_pile = $room->discard_pile;

        if ($player->president and count($cards_pile) == 3) {

            $discard_pile[] = $cards_pile[$discardCard];

            unset($cards_pile[$discardCard]);

            Room::where('id', $player->room_id)->update(['cards_pile' => json_encode(array_values($cards_pile)), 'discard_pile' => json_encode($discard_pile)]);
        }

        if ($player->chancellor and count($cards_pile) == 2) {

            $discard_pile[] = $cards_pile[$discardCard];
            unset($cards_pile[$discardCard]);

            Room::where('id', $player->room_id)->update(['cards_pile' => json_encode(array_values($cards_pile)), 'discard_pile' => json_encode($discard_pile)]);


            $remainigCard = implode(array_values($cards_pile));


            if ($remainigCard == 1) {
                Room::where('id', $player->room_id)->update(['cards_pile' => null]);
                $remainigCard = null;

                Room::where('id', $player->room_id)->increment('lib_board');
                return $this->checkBoard($player);
            } elseif ($remainigCard != null) {
                Room::where('id', $player->room_id)->update(['cards_pile' => null]);
                $remainigCard = null;
                Room::where('id', $player->room_id)->increment('fasc_board');
                return $this->checkBoard($player);
            }
        }
    }

    public function checkBoard($player)
    {
        //deze functie is om het bord checken of een van de groepen al gewonnen heeft 
        $room = Room::where('id', $player->room_id)->get()->first();
        if ($room->lib_board >= 5) {
            Room::where('id', $player->room_id)->update(['win' => 1]);
            return 'lib win';
        } elseif ($room->fasc_board >= 6) {
            Room::where('id', $player->room_id)->update(['win' => 0]);
            return 'fasc win';
        } else {
            return $this->nextRound($player, 0);
        }
    }

    public function nextRound($player, $keepLast)
    {
        $players = Player::where('room_id', $player->room_id)->get();
        $president = Player::where('room_id', $player->room_id)->where('president', 1)->value('order');

        if ($president == count($players)) {
            $nextPresident = 1;
        } else {
            $nextPresident = $president + 1;
        }

        Player::where('room_id', $player->room_id)->where('president_last', 1)->update(['president_last' => 0]);
        if ($keepLast == 0) {
            Player::where('room_id', $player->room_id)->where('chancellor_last', 1)->update(['chancellor_last' => 0]);
        }
        Player::where('room_id', $player->room_id)->where('chancellor_elected', 1)->update(['chancellor_elected' => 0]);

        Player::where('room_id', $player->room_id)->where('president', 1)->update(['president' => 0, 'president_last' => 1]);
        Player::where('room_id', $player->room_id)->where('chancellor', 1)->update(['chancellor' => 0, 'chancellor_last' => 1]);

        Player::where('room_id', $player->room_id)->where('order', $nextPresident)->update(['president' => 1]);

        return $players;
    }
}
