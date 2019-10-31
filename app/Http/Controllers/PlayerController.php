<?php

namespace App\Http\Controllers;


use App\Http\Controllers\RoomController;

use App\Player;
use App\Room;
use App\User;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $player = $request->user()->player;
        $room = Room::where('id', $player->room_id)->get()->first();

        if ($player->fasc or $room->win ===  0 or $room->win == 1) {
            $data['players'] = Player::where('room_id', $player->room_id)->where('user_id', '!=', $player->user_id)->get([
                'order',
                'user_id',
                'ready',
                'vote',
                'chancellor_elected',
                'chancellor',
                'chancellor_last',
                'president',
                'president_last',
                'fasc',
                'hitler',
            ])->sortBy('order')->values()->all();
        } else {
            $data['players'] = Player::where('room_id', $player->room_id)->where('user_id', '!=', $player->user_id)->get([
                'order',
                'user_id',
                'ready',
                'vote',
                'chancellor_elected',
                'chancellor',
                'chancellor_last',
                'president',
                'president_last',
            ])->sortBy('order')->values()->all();
        }

        $data['players'][] = Player::where('id', $player->id)->get([
            'order',
            'user_id',
            'ready',
            'chancellor_elected',
            'chancellor',
            'chancellor_last',
            'president',
            'president_last',
            'fasc',
            'hitler'
        ])->first();


        $data['player'] = Player::where('id', $player->id)->get([
            'order',
            'user_id',
            'ready',
            'vote',
            'chancellor_elected',
            'chancellor',
            'chancellor_last',
            'president',
            'president_last',
            'fasc',
            'hitler'
        ])->first();

        $data['room'] = Room::where('id', $player->room_id)->get([
            'name',
            'user_id',
            'draw_pile',
            'discard_pile',
            'lib_board',
            'fasc_board',
            'nein_counter',
            'vote',
            'win'
        ])->first();


        $cards_pile = Room::where('id', $player->room_id)->pluck('cards_pile')->first();

        if ($player->president and $cards_pile and count($cards_pile) == 3) {
            $data['cards'] = $cards_pile;
        } elseif ($player->chancellor and $cards_pile and count($cards_pile) == 2) {
            $data['cards'] = $cards_pile;
        }

        $count = 0;
        foreach ($data['players'] as $player) {
            $user = User::where('id', $player->user_id)->pluck('name')->first();
            $data['players'][$count]['username'] = $user;
            $count++;
        }


        $data['players'] = collect($data['players'])->sortBy('order')->values()->all();

        if ($data['room']['draw_pile']) {
            $data['room']['draw_pile'] = count($data['room']['draw_pile']);
        }
        if ($data['room']['discard_pile']) {
            $data['room']['discard_pile'] = count($data['room']['discard_pile']);
        }

        return $data;
    }

    public function store(Request $request)
    {
        $player = Player::create($request->all());
        return response()->json($player, 201);
    }

    public function show(Request $request)
    {
        $player = $request->user()->player;
        return Player::find($player->id);
    }

    public function update(Request $request, Player $player)
    {
        $player->update($request->all());
        return response()->json($player, 200);
    }

    public function delete(Player $player)
    {
        $player->delete();
        return response()->json(null, 204);
    }

    public function destroy()
    {
        Player::truncate();
        return response()->json(null, 204);
    }

    public function joinRoom(Request $request, Room $room)
    {
        $user = $request->user();
        $ammountPlayers = Player::where('room_id', $room->id)->count();

        $orderPlayers = Player::where('room_id', $room->id)->pluck('order')->toArray();

        if (player::where('user_id',  $user->id)->exists()) {

            $playerRoom = player::where('room_id', $room->id)->where('user_id', $user->id)->exists();
            if ($playerRoom == 1) {
                return redirect('/game');
            } else {

                $request->user()->player->delete();
                if (in_array(0, $orderPlayers) or empty($orderPlayers) and $ammountPlayers <= 6) {
                    Player::create(['user_id' => $user->id, 'room_id' => $room->id]);
                } else {
                    return 'game has started or to mutch players';
                }
            }
        } else {
            if (in_array(0, $orderPlayers) or empty($orderPlayers) and $ammountPlayers <= 6) {

                Player::create(['user_id' => $user->id, 'room_id' => $room->id]);
            } else {
                return 'game has starteddd or to mutch players';
            }
        }

        return redirect('/game');
    }

    public function leaveRoom(Request $request)
    {
        $player = $request->user()->player;

        if ($player) {
            $orderPlayers = Player::where('room_id', $player->room_id)->pluck('order')->toArray();

            if (in_array(0, $orderPlayers) or empty($orderPlayers)) {
                if (player::where('user_id', '=', $request->user()->id)->exists()) {
                    $player->delete();
                }
            }
        }



        return redirect('/lobby');
    }

    public function playerReady(Request $request)
    {
        $player = $request->user()->player;

        // als een ingelogde user bestaat in de player tabel dan update ready naar 1
        Player::where('user_id', $player->user_id)->update(['ready' => 1]);

        // kijken of alle spelers in een room klaar zijn om te beginnen
        $players = Player::where('room_id', $player->room_id)->pluck('user_id');
        $readyPlayers = Player::where('room_id', $player->room_id)->pluck('ready')->toArray();

        $orderPlayers = Player::where('room_id', $player->room_id)->pluck('order')->toArray();

        // om te spelen moeten er meer dan 5 spelers zijn de controle voor maximaal aantal spelers komt in joinRoom functie
        if (App::environment('production', 'staging')) {
            $neededPlayers = 5;
        } else {
            $neededPlayers = 3;
        }
        if (count($readyPlayers) >= $neededPlayers) {
            if (in_array(0, $readyPlayers)) {
                // niet alle spelers zijn klaar om te beginnen
                return response()->json(null, 204);
                return 'niet klaar om te beginnen';
            } elseif (in_array(0, $orderPlayers)) {

                // alle spelers zijn klaar om te beginnen
                return $this->startGame($request, $players);
            } else {
                return 'game has started';
            }
        } else {
            return response()->json(null, 204);
        }
    }

    public function startGame(Request $request, $players)
    {
        $player = $request->user()->player;
        // in elke room zit deze speler
        // tel het aantal spelers
        $numberPlayers = count($players->toArray());
        // schud de spelers om een wilekeurige order te maken
        $shufeledPlayers = $players->shuffle();
        // de order word opvolgorde ingevuld
        $i = 0;
        foreach ($shufeledPlayers as $shufeledPlayer) {
            $i++;
            Player::where('user_id', $shufeledPlayer)->update(['order' => $i]);
        }

        // er word willekeuging een fasist en een hitler gekozen
        $fasc = rand(1, $numberPlayers);
        do {
            $fascAndHitler = rand(1, $numberPlayers);
        } while ($fasc == $fascAndHitler);

        // update de spelers om de fascist en hitler te maken en de eerste president
        Player::where('order', $fasc)->where('room_id', $player->room_id)->update(['fasc' => 1]);
        Player::where('order', $fascAndHitler)->where('room_id', $player->room_id)->update(['fasc' => 1, 'hitler' => 1]);
        Player::where('order', 1)->where('room_id', $player->room_id)->update(['president' => 1]);

        return $this->genarateCards($player);
    }

    public function genarateCards($player)
    {
        // deze functie is om kaarten aan het begin van het spel te genereren
        // de nummers zijn gebaseerd op de pdf download
        $ammountOfLibCards = 6;
        $ammountOfFascCards = 11;

        $libCards = array_fill(0, $ammountOfLibCards, 1);
        $fascCards = array_fill(0, $ammountOfFascCards, 0);

        $cards = array_merge($libCards, $fascCards);
        shuffle($cards);

        Room::where('id', $player->room_id)->update(['draw_pile' => json_encode($cards)]);
        return redirect('/game');
    }

    // De functies chooseChancellor tot chancellorNotApproved zijn voor het kiezen en stemmen over
    public function chooseChancellor(Request $request, $chancellor)
    {
        // kiezen van kanselier
        $player = $request->user()->player;

        // return Player::where('room_id', $player->room_id)->where('order', $chancellor)->value('chancellor_last');

        if (
            Player::where('room_id', $player->room_id)->where('order', $chancellor)->value('chancellor_last') == 0
            and Player::where('room_id', $player->room_id)->where('order', $chancellor)->value('president') == 0
            and Player::where('room_id', $player->room_id)->where('chancellor_elected', 1)->doesntExist()
            and Player::where('room_id', $player->room_id)->where('chancellor', 1)->doesntExist()
        ) {

            // aleen de president mag een kanselier kiezen
            if ($player->president) {
                Player::where('room_id', $player->room_id)
                    ->where('order', $chancellor)
                    ->where('president', 0)
                    ->where('chancellor_last', 0)
                    ->update(['chancellor_elected' => 1]);


                Player::where('room_id', $player->room_id)->update(['vote' => null]);

                Room::where('id', $player->room_id)->update(['vote' => 1]);
            }
        } else {
            return 'kan niet verkozen worden';
        }
    }

    public function vote(Request $request, $vote)
    {
        // je stem registeren
        $player = $request->user()->player;
        if ($player->vote === null) {
            Player::where('room_id', $player->room_id)
                ->where('user_id', $player->user_id)
                ->update(['vote' => $vote]);

            return $this->checkVote($player);
        } else {
            return 'you already voted!';
        }
    }

    public function checkVote($player)
    {
        // stemmen tellen 
        $playersvote = Player::where('room_id', $player->room_id)->pluck('vote');

        $ja = 0;
        $nein = 0;
        foreach ($playersvote as $playervote) {
            if ($playervote === null) {
                return 'not everyone has voted';
            }
            if ($playervote == 1) {
                $ja++;
            }
            if ($playervote == 0) {
                $nein++;
            }
        }
        // als er meer votes ja zijn dan word de kanselier goedgekeurd
        if ($ja > $nein) {
            return $this->chancellorApproved($player);
        } else {
            return $this->chancellorNotApproved($player);
        }
    }

    public function chancellorApproved($player)
    {
        $room = Room::where('id', $player->room_id)->get()->first();
        $electedPlayer = Player::where('room_id', $player->room_id)
            ->where('chancellor_elected', 1)
            ->get()->first();

        if ($electedPlayer->hitler and $room->fasc_board >= 3) {
            Room::where('id', $player->room_id)->update(['vote' => 0, 'win' => 0]);
            return 'fasc win hitler was elected ';
        } else {
            // return $this->drawCards($player);


            Room::where('id', $player->room_id)->update(['nein_counter' => 0]);

            // de kanselier word kanselier gemaakt en de 'chancellor_elected' word weer truggezet
            Player::where('room_id', $player->room_id)
                ->where('chancellor_elected', 1)
                ->update(['chancellor' => 1, 'chancellor_elected' => 0]);

            Player::where('room_id', $player->room_id)->update(['vote' => null]);

            Room::where('id', $player->room_id)->update(['vote' => 0]);

            return $this->drawCards($player);
            // kaarten pakken
        }
    }

    public function drawCards($player)
    {

        $drawCards = Room::where('id', $player->room_id)->pluck('draw_pile')->first();
        // return $drawCards;

        // er moeten wel 3 kaarten zijn anders moet er opnieuw geschud worden
        if (count($drawCards) < 3) {
            return $this->shuffleCards($player);
        }

        // return $drawCards;
        // dit naar draw pile
        $draw_pile = array_slice($drawCards, 3);
        // eerste 3 kaarten naar card pile en return
        $cards_pile = array_slice($drawCards, 0, 3);

        Room::where('id', $player->room_id)->update(['draw_pile' => json_encode($draw_pile), 'cards_pile' => json_encode($cards_pile)]);
    }

    public function chancellorNotApproved($player)
    {
        $room = Room::where('id', $player->room_id)->get()->first();
        Room::where('id', $player->room_id)->increment('nein_counter');

        if ($room->nein_counter == 2) {
            Room::where('id', $player->room_id)->update(['nein_counter' => 0]);
            return $this->topDeck($player);
        }

        // een functie voor enetueel een nein tracker
        return app('App\Http\Controllers\RoomController')->nextRound($player, 1);
        return 'not aproved';
    }

    public function topDeck($player)
    {
        $draw_pile = Room::where('id', $player->room_id)->pluck('draw_pile')->first();

        if (count($draw_pile) < 3) {
            return $this->shuffleCards($player);
        }
        $remainigCard = $draw_pile[0];
        unset($draw_pile[0]);
        Room::where('id', $player->room_id)->update(['draw_pile' => json_encode(array_values($draw_pile))]);

        if ($remainigCard == 2) {
            Room::where('id', $player->room_id)->increment('lib_board');
            return app('App\Http\Controllers\RoomController')->checkBoard($player);
        } else {
            Room::where('id', $player->room_id)->increment('fasc_board');
            return app('App\Http\Controllers\RoomController')->checkBoard($player);
        }
        return $draw_pile;
    }


    public function shuffleCards($player)
    {
        $room = Room::where('id', $player->room_id)->get()->first();
        // deze functie is om kaarten opniew te schudden
        $draw_pile = $room->draw_pile;
        $discard_pile = $room->discard_pile;

        $draw_pile = array_merge($draw_pile, $discard_pile);
        shuffle($draw_pile);
        Room::where('id', $room->id)->update(['draw_pile' => json_encode($draw_pile), 'discard_pile' => null]);
        return $this->drawCards($player);
    }
}
