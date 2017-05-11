$(document).ready(function(){
// Defining the player
var player = document.getElementById('audio');

// Play button
$('#play').click(function(){
player.play();
})

// Stop button
// IT TOOK ME AN HOUR TO FIGURE OUT THAT THIS WOULD WORK
$('#stop').click(function () {
            audio.pause();
            audio.src = '';
            audio.src = 'http://uk6.internet-radio.com:8498/live';
        });
        
// Mute Button
var audio = document.getElementById('audio');

document.getElementById('mute').addEventListener('click', function (e)
{
    e = e || window.event;
    audio.muted = !audio.muted;
    this.src = audio.muted ? './img/player/muted.png' :
                './img/player/unmuted.png';
    e.preventDefault();
}, false);



// Volume bar
$('#volume').on('input change', function () {
            audio.volume = this.value / 100;
        });
});

