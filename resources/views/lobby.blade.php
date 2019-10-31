@extends('layouts.app')

@section('content')
<div class="py-4 ">
    <div class="container">
        <div class="d-flex justify-content-between">
            <a class="btn btn-outline-success disabled">{{ucfirst($user->name)}}</a>
            <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#myModal">Make room</button>


            <a class="btn btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </div>
        <div class="row justify-content-center" id="rooms"></div>

        <div class="row justify-content-center">

            <!-- @foreach($rooms as $room)
            <div class="card w-100 m-3">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h4 class="card-title"> {{ ucfirst($room->name) }}</h4>
                        <p class="card-text">Date: {{$room->created_at}} , Room ID: {{$room->id}} <br> Made
                            by: {{ucfirst($room->user->name)}}</p>
                    </div>

                    <div class="p-4">
                        @if($user->id == $room->user_id)
                        <a href="api/rooms/delete?api_token={{$user->api_token}}" class="btn btn-outline-danger">Delete Room</a>
                        @endif
                        <a href="api/rooms/join/{{$room->id}}?api_token={{$user->api_token}}" class="btn btn-outline-primary">Join Room</a>
                    </div>
                </div>
            </div>
            @endforeach -->

        </div>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Make room!</h4>
                    </div>
                    <div class="modal-body">


                        <div class="form-group">
                            <label for="name">Name of room:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="name of room here...">
                        </div>
                        <button id="newRoom" type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var getData = function() {
            $.ajax({
                type: "get",
                url: "api/rooms/data?api_token={{$user->api_token}}",
                datatype: "html",
                success: function(data) {
                    console.log(data);


                    $('#rooms').empty();

                    for (let i = 0; i < data.length; i++) {

                        let $cardText = $("<div/>")
                            .attr("id", "room" + i)
                            .html("<p>AmmountOfPlayers: " + data[i]['ammountOfPlayers'] + "<br>MadeBy: " + data[i]['username'] + "</p>")
                            .addClass("card-text");

                        let $cardTitle = $("<div/>")
                            .attr("id", "room" + i)
                            .html("<h4>" + data[i]['name'] + "</h4>")
                            .addClass("card-title");

                        let $text = $("<div/>")
                            .attr("id", "room" + i)
                            .addClass("")
                            .append($cardTitle)
                            .append($cardText);

                        let $joinRoom = $("<button/>")
                            .attr("id", "room" + i)
                            .addClass("btn btn-outline-primary")
                            .click(function() {
                                window.location = 'api/rooms/join/' + data[i]['id'] + '?api_token={{$user->api_token}}';
                            })
                            .text('join room');

                        let $buttonContainer = $("<div/>")
                            .attr("id", "room" + i)
                            .addClass("p-4")
                            .append($joinRoom);



                        let $cardBody = $("<div/>")
                            .attr("id", "room" + i)
                            .addClass("card-body d-flex justify-content-between")
                            .append($text)
                            .append($buttonContainer);

                        let $newRoom = $("<div/>")
                            .attr("id", "room" + i)
                            .addClass("card w-100 m-3")
                            .html($cardBody);

                        $("#rooms").append($newRoom);
                    }
                }
            });
        };
        getData();
        setInterval(getData, 1500);

        $(document).ready(function() {
            $("#newRoom").click(function() {
                let name = $('#name').val();

                $.ajax({
                    type: "post",
                    url: "api/rooms?name=" + name + "&api_token={{$user->api_token}}",
                    datatype: "html",
                    success: function(result) {
                        getData();
                        console.log(result);
                        $('#myModal').modal('hide');
                    }
                });
            });
        });
    </script>
</div>




@endsection