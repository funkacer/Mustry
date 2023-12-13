<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/85b5d6f521.js"></script>
    <title>Bar</title>
</head>
<body>
    <style>body {background:gray}</style>
    <div class="text-center">
    </div>

    <?php include './status-bar.latte' ?>
    <script src="./js/script.js"></script>
    <script src="./js/jquery-3.3.1.js"></script>

    <script>
    /*var link = 'https://koralky-skripty.arit.cz/worker/status';*/
    var link = 'http://localhost/mustry/css/cenik/status.php';

    window.onload = function () {
        sessionStorage.setItem("runned", false);
        sendIt();
        let inter = setInterval(function () {
            sendIt();
        }, 5000);
        function sendIt(runned) {
            $.ajax({
                url: link,
                error: function () {

                },
                success: function (res) {
                    let data = JSON.parse(res);
                    console.log(data);
                    if (data.running) {
                        $('#status-bar').show();
                        $('.spinner-grow').show();
                        $('.status-finished').hide();
                        sessionStorage.setItem("runned", true);
                    } else {
                        $('.spinner-grow').hide();
                        $('.status-finished').show();
                        if (sessionStorage.getItem("runned")) {
                            $('#link').show();
                            sessionStorage.setItem("runned", false);
                        }
                    }
                    $('#status-work').text(data.running === true ? 'Pracuji...' + " " + data.process : 'Hotovo' + ": " + data.process);
                    $('#status-percent').text(data.statusPercent);
                    $('#status-how-many ').text(data.finished + ' / ' + data.count);
                    if (data.running === false) {
                        clearInterval(inter);
                    }
                }
            });
        }
    };

</script>

</body>
</html>