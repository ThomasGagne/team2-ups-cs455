// Howler.js is best friggin library ever
var currentSong = new Howl({});
var isPlaying = false;
var timerInterval = null;
var timerValue = "00:00";
var timerDOM = null;

function startSong(songLocation) {
  if (currentSong.urls().indexOf("songs/" + songLocation) == -1) {
    loadNewSong(songLocation);
  }

  currentSong.play();
  isPlaying = true;
}

function pauseSong() {
  currentSong.pause();
  isPlaying = false;
}

function killSound(){
  timerDOM.innerHTML = "00:00";
  currentSong.stop();
  currentSong.unload();
}

function loadNewSong(songLocation) {
  killSound();
  currentSong = new Howl({
    urls: ["/songs/" + songLocation],
    buffer: true
  });

}

// Need to make an AJAX call here
function starSong(starringUsername, title, artist, uploader) {
  var star = document.getElementById(title + ":" + artist + ":" + uploader + ":star");
  if (star.style.color == ""){
    $.ajax({ url: '/starSong.php',
             data: {starringUsername: starringUsername,
                    title: title,
                    artist: artist,
                    uploader: uploader
                   },
             type: 'post',
             success: function(output) {
               star.style.color = "#cca300";
               star.disabled = true;
               var score = document.getElementById(title + ":" + artist + ":" + uploader + ":score");
               score.innerHTML = parseInt(score.innerHTML, 10) + 1;
             }
           });
  }
}

function playPauseSong(playID, location) {
  var playButton = document.getElementById(playID);
  timerDOM = document.getElementById(playID.substring(0, playID.length - 4) + "time");
  
  if (!isPlaying){
    startSong(location);
    playButton.innerHTML = "&#10074;&#10074;";
    timerInterval = setInterval(setTimer, 250);
  } else {
    pauseSong();
    clearInterval(timerInterval);
    playButton.innerHTML = "▶";
    clearInterval(timerInterval);
  }
}

function setTimer(){
  setTimerValue(Math.floor(currentSong.pos()));
}

function setTimerValue(seconds){
  var secondsPosition = seconds % 60;
  var minutesPosition = (seconds - secondsPosition) / 60;
  timerDOM.innerHTML = pad(minutesPosition, 2) + ":" + pad(secondsPosition, 2);
}

// How on earth does a modern language like JS not have a pad function?
function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}
