<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

    <div>
        <header>
            <h1>Faith Art</h1>
        </header>
        <nav>
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('blog') }}">Blog</a>
            <a href="{{ route('home') }}">Gallery</a>
            <a href="faithContact.html">Contact</a>
        </nav>
    </div>
    <div class="wrapper">
        <main>
            <br><br>
            <div id="homePagebox">
                <div id="anthony">
                    <div id="socialMedia">
                        <ol>
                            <a href="https://instagram.com">
                                <li id="insta"></li>
                            </a><br>
                            <a href="https://tumblr.com/">
                                <li id="tumblr"></li>
                            </a><br>
                            <a href="https://www.youtube.com">
                                <li id="youtube"></li>
                            </a>
                        </ol>
                    </div>
                    <img src="https://i.imgur.com/WRe0cLr.jpg" alt="about"></a>

                </div>
            </div>
        </main>
    </div>

</body>

</html>
