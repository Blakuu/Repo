<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My favourite movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="row">
    <div class="col-md-4" id="seen"></div>
    <div class="col-md-4" id="new" ></div>
    <div class="col-md-4" id="comment"></div>
</div>





<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<script type="text/javascript">
     $(document).ready(function() {

        $.ajax({
            method: 'get',
            url: '_seen.php',
            dataType: 'json',
            success: function(response) {
                $('#seen').html('<h2>Pobranych rekordów: ' + response.length + '</h2>');
                $(response).each(function( index, element ) {
                    $('#seen').append('<h3>'+element.title+' <small>(' + element.date + ')</small></h3>');
                    $('#seen').append('<div>'+element.description+'</div>');
                });
            }
        });
             
        $.ajax({
            method: 'get',
            url: '_new.php',
            dataType: 'json',
            success: function(response) {
                $('#new').html('<h2>Pobranych rekordów: ' + response.length + '</h2>');
                $(response).each(function( index, element ) {
                    $('#new').append('<h3>'+element.title+' <small>(' + element.date + ')</small></h3>');
                    $('#new').append('<div>'+element.description+'</div>');
                });
            }
        });

        $.ajax({
            method: 'get',
            url: '_comment.php',
            dataType: 'json',
            success: function(response) {
                $('#comment').html('<h2>Pobranych rekordów: ' + response.length + '</h2>');
                $(response).each(function( index, element ) {
                    $('#comment').append('<h3>'+element.author+' (' + element.created_at + ')</h3>');
                    $('#comment').append('<div>'+element.content+'</div>');
                });
            }
        })
    });
</script>
</body>
</html>