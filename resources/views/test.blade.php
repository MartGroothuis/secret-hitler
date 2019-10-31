<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function getName() {
            $.ajax({
                url: '/api/rooms',
                type: 'get',
                success: function(data) {
                    $("#div1").html(data[0].name);
                }
            });
        }
        getName();
    </script>
</head>

<body>

    <div id="div1">
        <h2>Let jQuery AJAX Change This Text</h2>
    </div>

    <div>
        <input placeholder="Search Here" id="search" />
    </div>
    <div id="feed"></div>

    <button>Get External Content</button>
    <script>
        $('#search').on('keyup', function() {
            console.log($('#search').val());


            $.ajax({
                url: '/api/room/1',
                type: 'PUT',
                data: "name=" + $('#search').val(),
                success: function(data) {
                    console.log('good');
                    getName();
                }
            });

        });
    </script>

</body>

</html>