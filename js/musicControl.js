// Howler.js is best friggin library ever
var currentSong = new Howl({});
var isPlaying = false;

function startSong(songLocation) {
  if (currentSong.urls().indexOf(songLocation) == -1) {
    loadNewSong(songLocation);
  }

  currentSong.play();
  isPlaying = true;
}

function stopSong() {
  currentSong.stop();
  isPlaying = false;
}

function loadNewSong(songLocation) {
  currentSong.unload();
  currentSong = new Howl({
    urls: ["songs/" + songLocation],
    buffer: true
  });

}
