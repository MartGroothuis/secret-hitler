@extends('layouts.app')

@section('content')

<div class="container-fluid py-2 " style="background-color: darkslategrey; height: 100vh;">
    <div class="row justify-content-center p-2">
        <div class="col-7 d-flex flex-wrap justify-content-between">
            <div class="row d-flex align-content-between flex-wrap">
                <div class="w-100 " id="">
                    <img class="card-img-top" src="{{ asset('images/tracks/liberaltrack.png') }}">
                    <div class="h-50 liberaltrack">
                        <div class="h-100 d-flex justify-content-between align-self-center">
                            <div class="w-100">
                                <div class="w-100 h-100 d-none liberalcard" id="liberalcard1"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none liberalcard" id="liberalcard2"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none liberalcard" id="liberalcard3"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none liberalcard" id="liberalcard4"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none liberalcard" id="liberalcard5"></div>
                            </div>
                        </div>
                    </div>
                    <div class="h-50 electiontrack">
                        <div class="h-100 d-flex justify-content-between align-self-center electioncontainer">
                            <div class="w-100 election">
                                <div class="w-100 h-100 d-none electionimg" id="election0"></div>
                            </div>
                            <div class="w-100 election">
                                <div class="w-100 h-100 d-none electionimg" id="election1"></div>
                            </div>
                            <div class="w-100 election">
                                <div class="w-100 h-100 d-none electionimg" id="election2"></div>
                            </div>
                            <div class="w-100 election">
                                <div class="w-100 h-100 d-none electionimg" id="election3"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 ">
                    <img class="card-img-top" src="{{ asset('images/tracks/fascisttrack56.png') }}">
                    <div class="h-50 fascisttrack56">
                        <div class=" h-100 d-flex justify-content-between align-self-center">
                            <div class=" w-100">
                                <div class="w-100 h-100 d-none fascistcard" id="fascistcard1"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none fascistcard" id="fascistcard2"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none fascistcard" id="fascistcard3"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none fascistcard" id="fascistcard4"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none fascistcard" id="fascistcard5"></div>
                            </div>
                            <div class="w-100">
                                <div class="w-100 h-100 d-none fascistcard" id="fascistcard6"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 ">
            <div class="card h-100 ">
                <div class="card-header d-flex justify-content-between">
                    <h2 class="card-title">{{ucfirst($room->name)}}</h2>
                    <div>
                        @if($user->id == $room->user_id)
                        <a href="api/rooms/delete?api_token={{$user->api_token}}" class="btn btn-outline-danger">Delete Room</a>
                        @endif
                        <a href="api/rooms/leave?api_token={{$user->api_token}}" class="btn btn-outline-danger">Leave
                            Room</a>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div id="log">
                        <li>{{ ucfirst($user->name)}}</li>
                        <div id="role"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button id="readyButton" class="btn btn-outline-success">I'm ready</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 d-flex justify-content-between">
            <div class="card m-2 w-100 border" id="playercard0">
                <div class="card-body d-flex justify-content-between" id="playerNameContainer0">
                    <h5 class="card-title text-capitalize" id="playername0">player</h5>
                    <h5 class="card-title text-capitalize" id="vote0"></h5>
                </div>
                <div class="card-footer bg-dark" id="playerstate0"></div>
            </div>
            <div class="card m-2 w-100 border" id="playercard1">
                <div class="card-body d-flex justify-content-between" id="playerNameContainer1">
                    <h5 class="card-title text-capitalize" id="playername1">player</h5>
                    <h5 class="card-title text-capitalize" id="vote1"></h5>
                </div>
                <div class="card-footer bg-dark" id="playerstate1"></div>
            </div>
            <div class="card m-2 w-100 border" id="playercard2">
                <div class="card-body d-flex justify-content-between" id="playerNameContainer2">
                    <h5 class="card-title text-capitalize" id="playername2">player</h5>
                    <h5 class="card-title text-capitalize" id="vote2"></h5>
                </div>
                <div class="card-footer bg-dark" id="playerstate2"></div>
            </div>
            <div class="card m-2 w-100 border" id="playercard3">
                <div class="card-body d-flex justify-content-between" id="playerNameContainer3">
                    <h5 class="card-title text-capitalize" id="playername3">player</h5>
                    <h5 class="card-title text-capitalize" id="vote3"></h5>
                </div>
                <div class="card-footer bg-dark" id="playerstate3"></div>
            </div>
            <div class="card m-2 w-100 border" id="playercard4">
                <div class="card-body d-flex justify-content-between" id="playerNameContainer4">
                    <h5 class="card-title text-capitalize" id="playername4">player</h5>
                    <h5 class="card-title text-capitalize" id="vote4"></h5>
                </div>
                <div class="card-footer bg-dark" id="playerstate4"></div>
            </div>
            <div class="card m-2 w-100 border" id="playercard5">
                <div class="card-body d-flex justify-content-between" id="playerNameContainer5">
                    <h5 class="card-title text-capitalize" id="playername5">player</h5>
                    <h5 class="card-title text-capitalize" id="vote5"></h5>
                </div>
                <div class="card-footer bg-dark" id="playerstate5"></div>
            </div>
            <div class="card m-2  w-100 border">
                <div class="card-body">
                    <h5 class="card-title">Draw Pile</h5>
                </div>
                <div class="card-footer" id="draw_pile">0</div>
            </div>
            <div class="card m-2  w-100 border">
                <div class="card-body">
                    <h5 class="card-title">Discard Pile</h5>
                </div>
                <div class="card-footer" id="discard_pile">0</div>
            </div>
        </div>
    </div>
    <div class="alert alert-success m-2 d-none" id="libWin" role="alert">
        lib win!
    </div>
    <div class="alert alert-danger m-2 d-none" id="fasistWin" role="alert">
        Fasist win!
    </div>
    <!-- Modal -->
    <div class="modal fade" id="discardCard" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Click on what to discard</h2>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <img class="card-img-top m-2 border d-none" id="policyCard0">
                        <img class="card-img-top m-2 border d-none" id="policyCard1">
                        <img class="card-img-top m-2 border d-none" id="policyCard2">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="selectVote" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" id="chancellorName">
                    Vote For Chancellor
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <img class="card-img-top m-2 mr-3 border" id="voteJa" src="{{ asset('images/cards/ja-l.png') }}">
                        <img class="card-img-top m-2 ml-3 border" id="voteNein" src="{{ asset('images/cards/nein-l.png') }}">
                    </div>
                </div>
            </div>
            <script>
                let done = 0;
                var getData = function() {
                    $.ajax({
                        type: "get",
                        url: "api/data?api_token={{$user->api_token}}",
                        datatype: "html",
                        success: function(data) {
                            // console.log(data);
                            console.log('data');


                            window.onbeforeunload = function() {
                                if (data['player']['order'] != 0) {
                                    return 'wil je echt weggaan?'
                                }
                                $.ajax({
                                    type: "get",
                                    url: "api/rooms/leave?api_token={{$user->api_token}}",
                                    datatype: "html",
                                    success: function(result) {
                                        console.log(result);
                                    }
                                });
                            };

                            // win status
                            if (data['room']['win'] == 1) {
                                $('#libWin').removeClass('d-none');
                            }
                            if (data['room']['win'] == 0) {
                                $('#fasistWin').removeClass('d-none');
                            }
                            // readyknop
                            if (data['player']['ready']) {
                                $('#readyButton').addClass("d-none");
                            }

                            if (data['player']['oreder'] !== 0) {
                                selectChancellor(data);
                            }


                            // cards modal
                            if (data['cards']) {
                                selectCards(data);
                            } else {
                                $('#discardCard').modal('hide');
                                executedSelectCards = false;
                            }

                            // voting modal
                            if (data['room']['vote'] && data['player']['vote'] == null) {
                                $('#selectVote').modal('show');
                            } else {
                                $('#selectVote').modal('hide');
                            }


                            // zorgen dat niks niet null is
                            if (data['room']['draw_pile'] == null) {
                                data['room']['draw_pile'] = 0;
                            }
                            $('#draw_pile').html(data['room']['draw_pile']);
                            if (data['room']['discard_pile'] == null) {
                                data['room']['discard_pile'] = 0;
                            }
                            $('#discard_pile').html(data['room']['discard_pile']);

                            // cards update
                            let libBoard = data['room']['lib_board']
                            let fascCards = data['room']['fasc_board']
                            let election = data['room']['nein_counter']
                            for (let i = 1; i < libBoard + 1; i++) {
                                $('#liberalcard' + i).removeClass("d-none");
                            }
                            for (let i = 1; i < fascCards + 1; i++) {
                                $('#fascistcard' + i).removeClass("d-none");
                            }
                            for (let i = 0; i < 4; i++) {
                                $('#election' + i).addClass("d-none");
                            }
                            for (let i = 0; i < election + 1; i++) {
                                $('#election' + i).removeClass("d-none");
                            }


                            let playerOrder = data['player']['order'] - 1;

                            // de lege plekken van spelers
                            for (let i = data['players'].length; i < 6; i++) {
                                $playerName = null;
                                $playerState = null;
                                $bgColor = 'dark';
                                $textColor = null;
                                $playerNameColor = null;
                                $('#playername' + i).html('player');
                                $('#playercard' + i).addClass("d-none");
                                $('#playercard' + i).removeClass("bg-dark");
                                changePlayerStatus($playerState, $bgColor, $textColor, $playerName, $playerNameColor, i);
                            }

                            // for alle spelers
                            for (let i = 0; i < data['players'].length; i++) {


                                $user_id = data['players'][i]['user_id'];
                                let $username = '';
                                if (data['players'][i]['order'] != 0) {
                                    $username = data['players'][i]['order'] + '. ';
                                }
                                $('#playername' + i).html($username + data['players'][i]['username']);

                                $('#playercard' + i).removeClass("d-none");
                                $('#playercard' + i).removeClass("bg-dark");

                                $playerNameColor = '';
                                $playerName = '';

                                $playerState = '';
                                $bgColor = '';
                                $textColor = '';

                                // voting bij speler
                                // if (data['players'][i]['vote'] == 1) {
                                //     $('#vote' + i).text('ja!');
                                // }
                                // if (data['players'][i]['vote'] == 0) {
                                //     $('#vote' + i).text('nein');
                                // }



                                // kleuren op namen
                                if (data['players'][i]['order'] != 0) {
                                    if (data['players'][i]['fasc'] == 1) {
                                        $playerNameColor = 'text-danger';
                                        role = 'fasc';
                                        $("#role").html('<li class="' + $playerNameColor + '">youre ' + role + '</li>');
                                    }
                                    if (data['players'][i]['hitler'] == 1) {
                                        $playerNameColor = 'text-warning';
                                        role = 'hitler';
                                        $("#role").html('<li class="' + $playerNameColor + '">youre ' + role + '</li>');
                                    }
                                    if (data['players'][i]['hitler'] == 0 && data['players'][i]['fasc'] == 0) {
                                        $playerNameColor = 'text-info';
                                        role = 'lib';
                                        $("#role").html('<li class="' + $playerNameColor + '">youre ' + role + '</li>');
                                    }
                                }

                                if (data['players'][i]['ready'] == 0) {
                                    $bgColor = 'danger';
                                    $playerState = 'Not Ready';
                                    $textColor = 'white';
                                }
                                // if (data['players'][i]['president_last'] == 1) {
                                //     $playerState = 'president_last'
                                // }
                                if (data['players'][i]['chancellor_last'] == 1) {
                                    $playerState = 'chancellor_last'
                                }
                                if (data['players'][i]['chancellor_elected'] == 1) {
                                    $playerState = 'chancellor_elected'
                                    $bgColor = 'light';
                                    let chancellorName = data['players'][i]['username'];
                                    $('#chancellorName').text('Vote ' + chancellorName + ' as chancellor?');
                                }
                                if (data['players'][i]['president'] == 1) {
                                    $playerState = 'president'
                                    $bgColor = 'secondary';
                                    $textColor = 'white';
                                }
                                if (data['players'][i]['chancellor'] == 1) {
                                    $playerState = 'Chancellor'
                                    $bgColor = 'secondary';
                                    $textColor = 'white';
                                }

                                changePlayerStatus($playerState, $bgColor, $textColor, $playerName, $playerNameColor, i);

                                if (data['players'][i]['order'] != 0) {
                                    if (data['player']['fasc'] == 1) {
                                        $playerNameColor = 'text-danger';
                                        role = 'fasc';
                                        $("#role").html('<li class="' + $playerNameColor + '">youre ' + role + '</li>');
                                    }
                                    if (data['player']['hitler'] == 1) {
                                        $playerNameColor = 'text-warning';
                                        role = 'hitler';
                                        $("#role").html('<li class="' + $playerNameColor + '">youre ' + role + '</li>');
                                    }
                                    if (data['player']['hitler'] == 0 && data['player']['fasc'] == 0) {
                                        $playerNameColor = 'text-info';
                                        role = 'lib';
                                        $("#role").html('<li class="' + $playerNameColor + '">youre ' + role + '</li>');
                                    }
                                }

                            }

                            $('#playerNameContainer' + playerOrder).addClass("bg-dark");


                        }

                    });
                };
                // getData();
                var interval = setInterval(getData, 1500);


                function start() {
                    console.log('start')
                    var interval = setInterval(getData, 1500);
                    getData();
                }


                function stop() {
                    console.log('stop')
                    clearInterval(interval)
                }

                stop()
                start();


                function changePlayerStatus($playerState, $bgColor, $textColor, $playerName, $playerNameColor, i) {
                    $('#playerstate' + i).removeClass("bg-secondary");
                    $('#playerstate' + i).removeClass("bg-danger");
                    $('#playerstate' + i).removeClass("bg-dark");
                    $('#playerstate' + i).removeClass("bg-light");
                    $('#playerstate' + i).removeClass("text-white");

                    $('#playerstate' + i).addClass("bg-" + $bgColor);
                    $('#playerstate' + i).addClass("text-" + $textColor);

                    $('#playerstate' + i).html($playerState);

                    $('#playername' + i).removeClass("text-info");
                    $('#playername' + i).removeClass("text-danger");
                    $('#playername' + i).removeClass("text-warning");


                    $('#playername' + i).addClass($playerNameColor);


                }

                let executed = false;
                let borderdark = 'border-dark';


                function selectChancellor(data) {
                    // let chancellorElected = false;
                    // for (let i = 0; i < data['players'].length; i++) {
                    //     if (data['players'][i]['chancellor_elected']) {
                    //         chancellorElected = true;
                    //         borderdark = '';
                    //         console.log('ff');
                    //             $('#playercard' + i).off("mouseenter");
                    //             $('#playercard' + i).off("mouseleave");
                    //     }
                    // }
                    // console.log(chancellorElected);

                    if (data['player']['president'] == 1) {
                        for (let i = 0; i < data['players'].length; i++) {
                            let x = i + 1;

                            if (data['player']['order'] != x && data['players'][i]['chancellor_last'] != 1) {
                                $("#playercard" + i).mouseenter(function() {
                                    $('#playerNameContainer' + i).addClass("bg-dark");

                                });

                                $("#playercard" + i).mouseleave(function() {
                                    $('#playerNameContainer' + i).removeClass("bg-dark");
                                });

                            }
                        }
                    } else {
                        for (let i = 0; i < data['players'].length; i++) {
                            let x = i + 1;

                            $("#playercard" + i).unbind('mouseenter mouseleave')

                        }
                    }

                    if (executed == false) {
                        executed = true;


                        for (let i = 0; i < 6; i++) {
                            let order = i + 1;
                            $("#playercard" + i).click(function() {
                                $.ajax({
                                    type: "put",
                                    url: "api/players/choose-chancellor/" + order + "?api_token={{$user->api_token}}",
                                    datatype: "html",
                                    success: function(result) {
                                        getData();
                                        console.log(result);
                                    }
                                });
                            });
                        }
                    };
                }

                let executedSelectCards = false;

                function selectCards(data) {
                    if (executedSelectCards == false) {
                        executedSelectCards = true;

                        $('#policyCard0').addClass("d-none");
                        $('#policyCard1').addClass("d-none");
                        $('#policyCard2').addClass("d-none");
                        $('#discardCard').modal('show');

                        for (let i = 0; i < data['cards'].length; i++) {

                            // console.log(data['cards'][i]);

                            if (data['cards'][i] == 0) {
                                $('#policyCard' + i).removeClass("d-none");
                                $('#policyCard' + i).attr("src", "{{ asset('images/cards/fascistp-l.png') }}");
                            }
                            if (data['cards'][i] == 1) {
                                $('#policyCard' + i).attr("src", "{{ asset('images/cards/liberalp-l.png') }}");
                                $('#policyCard' + i).removeClass("d-none");
                            }
                            $('#policyCard' + i).one('click', function() {
                                stop();
                                $.ajax({
                                    type: "put",
                                    url: "api/rooms/cards/" + i + "?api_token={{$user->api_token}}",
                                    datatype: "html",
                                    success: function(result) {
                                        $('#discardCard').modal('hide');
                                        console.log(result);
                                        start();
                                    }
                                });
                            });
                        }
                    }
                }

                $(document).ready(function() {



                    $("#voteJa").mouseenter(function() {
                        $('#voteJa').addClass("border-dark");
                    });
                    $("#voteJa").mouseleave(function() {
                        $('#voteJa').removeClass("border-dark");
                    });
                    $("#voteJa").click(function() {
                        $.ajax({
                            type: "put",
                            url: "api/players/vote/1?api_token={{$user->api_token}}",
                            datatype: "html",
                            success: function(result) {
                                getData();
                                console.log(result);
                                $('#selectVote').modal('hide');
                            }
                        });
                    });
                    $("#voteNein").mouseenter(function() {
                        $('#voteNein').addClass("border-dark");
                    });
                    $("#voteNein").mouseleave(function() {
                        $('#voteNein').removeClass("border-dark");
                    });
                    $("#voteNein").click(function() {
                        $.ajax({
                            type: "put",
                            url: "api/players/vote/0?api_token={{$user->api_token}}",
                            datatype: "html",
                            success: function(result) {
                                console.log(result);
                                getData();
                                $('#selectVote').modal('hide');
                            }
                        });
                    });
                    $("#policyCard0").mouseenter(function() {
                        $('#policyCard0').addClass("border-dark");
                    });
                    $("#policyCard0").mouseleave(function() {
                        $('#policyCard0').removeClass("border-dark");
                    });
                    $("#policyCard1").mouseenter(function() {
                        $('#policyCard1').addClass("border-dark");
                    });
                    $("#policyCard1").mouseleave(function() {
                        $('#policyCard1').removeClass("border-dark");
                    });
                    $("#policyCard2").mouseenter(function() {
                        $('#policyCard2').addClass("border-dark");
                    });
                    $("#policyCard2").mouseleave(function() {
                        $('#policyCard2').removeClass("border-dark");
                    });
                    $("#readyButton").click(function() {
                        $.ajax({
                            type: "get",
                            url: "api/players/ready?api_token={{$user->api_token}}",
                            datatype: "html",
                            success: function(result) {
                                getData();
                                console.log(result);
                                $('#readyButton').addClass("d-none");
                            }
                        });
                    });

                });
            </script>

        </div>


        @endsection