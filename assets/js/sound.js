var Sound = (function () {
    function Sound(url, audioContext, masterGain, loop, callback) {
        this.url = url;
        this.audioContext = audioContext;
        this.masterGain = masterGain;
        this.loop = loop;
        this.callback = callback;
        this.gain = this.audioContext.createGain();
        this.gain.connect(this.masterGain);
        this.isReadyToPlay = false;
        this.loadSoundFile(url);
    }
    Sound.prototype.loadSoundFile = function () {
        if (canUseWebAudio) {
            var that = this;
            // make XMLHttpRequest (AJAX) on server
            var xhr = new XMLHttpRequest();
            xhr.open('GET', this.url, true);
            xhr.responseType = 'arraybuffer';
            xhr.onload = function (e) {
                // decoded binary response
                that.audioContext.decodeAudioData(this.response,
                function (decodedArrayBuffer) {
                    // get decoded buffer
                    that.buffer = decodedArrayBuffer;
                    that.isReadyToPlay = true;
                    if (that.callback) {
                        that.callback();
                    }
                }, function (e) {
                    console.log('Error decoding file', e);
                });
            };
            xhr.send();
        }
    };
    Sound.prototype.play = function () {
        if (canUseWebAudio && this.isReadyToPlay) {
            // make source
            this.source = this.audioContext.createBufferSource();
            // connect buffer to source
            this.source.buffer = this.buffer;
            this.source.loop = this.loop;
            // connect source to receiver
            this.source.connect(this.gain);
            // play
            this.source.start(0);
        }
    };
    Sound.prototype.stop = function () {
        if (canUseWebAudio) {
            this.source.stop(0);
        }
    };
    return Sound;
})();