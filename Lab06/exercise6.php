<!DOCTYPE html>
<html lang="en">

<head>
    <title>Color Picker</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            transition: background-color 0.1s ease;
        }

        #board {
            width: 300px;
        }

        .cell {
            width: 30px;
            height: 30px;
            background-color: rgb(255, 255, 255);
            border: 0.5px solid black;
        }

        img {
            object-fit: cover;
            width: 100%;
            transform: matrix(1, 0, 0, 1, 0, 0);
        }

        .changed {
            width: 500px
        }

        #text-changed {
            background-color: #d4eddb;
        }

        #color-rgb {
            cursor: pointer;
        }
    </style>
</head>

<body>
<div id="board" class="container">
    <div class="row my-3">
        <div class="col m-0 p-0">
            <p id="color-rgb" class="h3 text-center my-3 bg-primary py-2 rounded text-white">
                rgb(0, 0, 0)
            </p>
        </div>
    </div>

    <!-- color palette -->
    <div class="row border border-dark">
        <div class="col p-0">
            <?php
                for($i = 0; $i < 10; $i++) {
                    echo '<div class="row">
                <div class="col d-flex justify-content-ceneter">
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                    <div class="cell"></div>
                </div>
            </div>';
                }
            ?>
        </div>
    </div>
</div>

<div class="container-fluid changed">
    <p id="text-changed" class="text-center my-3 py-2 rounded">
        Background color has been changed.
    </p>
</div>

<script>
    $(document).ready(function (event) {
        // console.log(event);
        let default_color = $("body").css("background-color");
        let text_box = $("#color-rgb");
        text_box.text(default_color);
        let changed_box = $("#text-changed");
        changed_box.hide();
        $(".row > .col > .cell")
            .each(function (index, elem) {
                let min = 0;
                let max = 255;
                let r = Math.floor(Math.random() * (max - min + 1) + min);
                let g = Math.floor(Math.random() * (max - min + 1) + min);
                let b = Math.floor(Math.random() * (max - min + 1) + min);
                $(elem).css("background-color", `rgb(${r} ${g} ${b})`);
            })
            .hover(function (event) {
                console.log($(event.target).css("background-color"));
                let temp_color = $(event.target).css("background-color");
                $("body").css("background-color", temp_color);
                text_box.text(temp_color);
            })
            .mouseout(function (event) {
                $("body").css("background-color", default_color);
                text_box.text(default_color);
                let temp_color = $(event.target).css("background-color");
            })
            .click(function (event) {
                let temp_color = $(event.target).css("background-color");
                default_color = temp_color;

                $("body").css("background-color", default_color);
                text_box.text(temp_color);

                changed_box.text("Background color has been changed.");
                changed_box.show().delay(3000).fadeOut();
            });

        // copy to clipboard
        text_box.click(function (event) {
            changed_box.text("Color has been copied to the clipboard");
            changed_box.show().delay(3000).fadeOut();
        });
    });
</script>
</body>

</html>