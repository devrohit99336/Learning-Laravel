<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>503</title>

    <style>
        root {
            cursor: none;
            --cursorX: 50vw;
            --cursorY: 50vh;
        }

        :root:before {
            content: '';
            z-index: 1;
            display: block;
            width: 100%;
            height: 100%;
            position: fixed;
            pointer-events: none;
            background: radial-gradient(circle 180px at var(--cursorX) var(--cursorY),
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, .5) 90%,
                    rgba(255, 255, 255, .96) 100%)
        }

        .cone {
            z-index: 99;
            width: 120px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            position: fixed;
            left: calc(50% - 40px);
            top: calc(10px + 3vw);
        }

        .headline {
            text-align: center;
            z-index: 100;
            position: relative;
            top: calc(150px + 3vw);
            font-size: 1.14285rem;
            color: #1c3b63;
            margin: 5px;
        }

        .subtitle {
            margin: 5px auto;
            text-align: center;
            z-index: 100;
            position: relative;
            top: calc(150px + 3vw);
            font-size: 1rem;
            font-weight: 400;
            color: #7c7c7c;
        }

        .main {
            height: 98vh;
            background-image: url('https://i.imgur.com/kueRMen.png');
            background-size: 1638px;
            background-position-x: calc((96vw - 1638px)/2);
            font-family: "Open Sans";
        }

        body {
            overflow: hidden;
        }

        @media only screen and (min-width: 1638px) {
            .main {
                background-size: cover;
                background-position-x: 0;
            }
        }

        @media only screen and (max-width: 600px) {
            .main {
                background-image: none;
            }

            :root:before {
                background: none;
            }
        }

    </style>
</head>

<body>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <main>
        <div class="main">
            {{-- <img class="cone" src="https://i.imgur.com/JtNfxJb.png"> --}}
            <h1 class="headline">
                This site is temporarily unavailable due to scheduled maintenance
            </h1>
            <h2 class="subtitle">Don't worry. We're working hard behind the scenes to get it running.</h2>
        </div>
    </main>

    <script>
        function update(e) {
            var x = e.clientX || e.touches[0].clientX
            var y = e.clientY || e.touches[0].clientY

            document.documentElement.style.setProperty('--cursorX', x + 'px')
            document.documentElement.style.setProperty('--cursorY', y + 'px')
        }

        document.addEventListener('mousemove', update)
        document.addEventListener('touchmove', update)
    </script>
</body>

</html>
