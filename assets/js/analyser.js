var Analyser = (function () {
    function Analyser(audioContext, outputGainNode) {
        this.SMOOTHING = 0.75;
        this.FFT_SIZE = 512;
        this.BARGRAPHAMPLITUDE = 256;
        this.DEBUGCANVASPOS = { x: 20, y: 20 };
        this.DEBUGCANVASSIZE = { width: 320, height: 50 };
        this.audioContext = audioContext;
		this.currentArray = Array();
		this.barColorDefault = 'hsl(202, 16%, 33%)';
		this.barColor = 'hsl(202, 16%, 33%)';
		this.domParent = document.body;
        if (canUseWebAudio) {
            this.webAudioAnalyser = this.audioContext.createAnalyser();
            this.webAudioAnalyser.minDecibels = -100;
            this.webAudioAnalyser.maxDecibels = 0;
            this.webAudioAnalyser.connect(outputGainNode);
            this._byteFreqs = new Uint8Array(this.webAudioAnalyser.frequencyBinCount);
            this._byteTime = new Uint8Array(this.webAudioAnalyser.frequencyBinCount);
            this._floatFreqs = new Float32Array(this.webAudioAnalyser.frequencyBinCount);
        }
    }
    Analyser.prototype.getFrequencyBinCount = function () {
        if (canUseWebAudio) {
            return this.webAudioAnalyser.frequencyBinCount;
        }
        else {
            return 0;
        }
    };
    Analyser.prototype.getByteFrequencyData = function () {
        if (canUseWebAudio) {
            this.webAudioAnalyser.smoothingTimeConstant = this.SMOOTHING;
            this.webAudioAnalyser.fftSize = this.FFT_SIZE;
            this.webAudioAnalyser.getByteFrequencyData(this._byteFreqs);
        }
        return this._byteFreqs;
    };
    Analyser.prototype.drawDebugCanvas = function () {
        var _this = this;
        if (canUseWebAudio) {
            if (!this._debugCanvas) {
                this._debugCanvas = document.createElement("canvas");
                this._debugCanvas.width = this.DEBUGCANVASSIZE.width;
                this._debugCanvas.height = this.DEBUGCANVASSIZE.height;
                this._debugCanvas.style.position = "absolute";
                this._debugCanvas.style.top = this.DEBUGCANVASPOS.y + "px";
                this._debugCanvas.style.left = this.DEBUGCANVASPOS.x + "px";
                this._debugCanvasContext = this._debugCanvas.getContext("2d");
                this.domParent.appendChild(this._debugCanvas);
                this._registerFunc = function () {
                    _this.drawDebugCanvas();
                };
                window.requestAnimationFrame(this._registerFunc);
            }
            if (this._registerFunc) {
                var workingArray = this.getByteFrequencyData();
				
				this.currentArray = workingArray;
				
                this._debugCanvasContext.fillStyle = 'rgb(255, 255, 255)';
                this._debugCanvasContext.fillRect(0, 0, this.DEBUGCANVASSIZE.width, this.DEBUGCANVASSIZE.height);
                for (var i = 0; i < this.getFrequencyBinCount() ; i++) {
                    var value = workingArray[i];
                    var percent = value / this.BARGRAPHAMPLITUDE;
                    var height = this.DEBUGCANVASSIZE.height * percent;
                    var offset = this.DEBUGCANVASSIZE.height - height - 1;
                    var barWidth = this.DEBUGCANVASSIZE.width / this.getFrequencyBinCount();
                    var hue = i / this.getFrequencyBinCount() * 360;
					this._debugCanvasContext.fillStyle = this.barColor;
                    this._debugCanvasContext.fillRect(i * barWidth, offset, barWidth, height);
                }
                window.requestAnimationFrame(this._registerFunc);
            }
        }
    };
    return Analyser;
})();