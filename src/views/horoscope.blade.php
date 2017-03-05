<!doctype html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<style>
    .position {

        position: fixed;
        left: 50%;
        top: 50%;
        -ms-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);

    }
</style>
<div class="position">
    <div class="container">
        <div class="row text-center">
            <h1>Your Emoji Horoscope for today..</h1>
            <div class="col-md-12 text-center">
                @foreach($emojis as $emoji)
                    @foreach($emoji->images as $image)
                        <img style="display:inline-block" width="30%" height="auto" src="{{ $image }}"
                             alt="{{ $emoji->name }}">
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>