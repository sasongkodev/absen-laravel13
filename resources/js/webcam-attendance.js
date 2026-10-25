/**
 * Presensi Webcam Client Handler
 * Native WebRTC camera access, canvas snapshot capture, and asynchronous submission.
 */

class WebcamAttendance {
    constructor() {
        this.video = document.getElementById('webcam-video');
        this.canvas = document.getElementById('webcam-canvas');
        this.snapshotContainer = document.getElementById('snapshot-preview-container');
        this.snapshotPreview = document.getElementById('snapshot-preview');
        this.snapshotTimestamp = document.getElementById('snapshot-timestamp');
        this.guideOverlay = document.getElementById('camera-guide-overlay');

        this.statusPill = document.getElementById('camera-status-pill');
        this.statusIndicator = document.getElementById('camera-indicator');
        this.statusText = document.getElementById('camera-status-text');

        this.errorBox = document.getElementById('camera-error-box');
        this.errorMessage = document.getElementById('camera-error-message');
        this.btnRetry = document.getElementById('btn-retry-camera');

        this.controlsCapture = document.getElementById('controls-capture');
        this.controlsSubmit = document.getElementById('controls-submit');

        this.btnCapture = document.getElementById('btn-capture');
        this.btnRetake = document.getElementById('btn-retake');
        this.btnCheckin = document.getElementById('btn-checkin');
        this.btnCheckout = document.getElementById('btn-checkout');

        this.stream = null;
        this.currentBlob = null;
        this.userLocation = null;

        if (this.video) {
            this.init();
        }
    }

    init() {
        this.startCamera();
        this.bindEvents();
        this.initGeolocation();
        this.initClock();
    }

    bindEvents() {
        if (this.btnCapture) {
            this.btnCapture.addEventListener('click', () => this.captureSnapshot());
        }

        if (this.btnRetake) {
            this.btnRetake.addEventListener('click', () => this.retakeSnapshot());
        }

        if (this.btnCheckin) {
            this.btnCheckin.addEventListener('click', () => this.submitAttendance('/presensi/check-in', 'in'));
        }

        if (this.btnCheckout) {
            this.btnCheckout.addEventListener('click', () => this.submitAttendance('/presensi/check-out', 'out'));
        }

        if (this.btnRetry) {
            this.btnRetry.addEventListener('click', () => {
                this.errorBox.classList.add('hidden');
                this.startCamera();
            });
        }
    }

    async startCamera() {
        this.updateStatus('connecting', 'Menghubungkan Kamera...');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            this.showError('Browser Anda tidak mendukung akses webcam WebRTC. Silakan gunakan browser modern (Chrome, Edge, Firefox, Safari).');
            return;
        }

        try {
            const constraints = {
                audio: false,
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user'
                }
            };

            this.stream = await navigator.mediaDevices.getUserMedia(constraints);
            this.video.srcObject = this.stream;
            
            this.video.onloadedmetadata = () => {
                this.video.play();
                this.updateStatus('active', 'Kamera Aktif');
                this.errorBox.classList.add('hidden');
                if (this.btnCapture) this.btnCapture.disabled = false;
            };
        } catch (err) {
            console.error('Webcam access error:', err);
            let message = 'Tidak dapat mengakses kamera.';
            if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                message = 'Izin kamera ditolak. Harap izinkan akses kamera di pengaturan browser Anda lalu klik coba lagi.';
            } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                message = 'Perangkat webcam tidak ditemukan. Pastikan webcam terpasang dengan benar.';
            } else if (err.name === 'NotReadableError' || err.name === 'TrackStartError') {
                message = 'Kamera sedang digunakan oleh aplikasi lain. Tutup aplikasi tersebut dan coba lagi.';
            }
            this.showError(message);
        }
    }

    stopCamera() {
        if (this.stream) {
            this.stream.getTracks().forEach(track => track.stop());
            this.stream = null;
        }
    }

    captureSnapshot() {
        if (!this.video || this.video.readyState !== 4) {
            this.showToast('Kamera belum siap, tunggu sebentar.', 'error');
            return;
        }

        const width = this.video.videoWidth || 640;
        const height = this.video.videoHeight || 480;

        this.canvas.width = width;
        this.canvas.height = height;

        const ctx = this.canvas.getContext('2d');
        ctx.drawImage(this.video, 0, 0, width, height);

        this.canvas.toBlob((blob) => {
            if (!blob) {
                this.showToast('Gagal memproses snapshot kamera.', 'error');
                return;
            }

            this.currentBlob = blob;
            const previewUrl = URL.createObjectURL(blob);
            this.snapshotPreview.src = previewUrl;

            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour12: false }) + ' WIB';
            if (this.snapshotTimestamp) {
                this.snapshotTimestamp.textContent = timeString;
            }

            // Switch views
            this.guideOverlay.classList.add('hidden');
            this.snapshotContainer.classList.remove('hidden');

            this.controlsCapture.classList.add('hidden');
            this.controlsSubmit.classList.remove('hidden');
        }, 'image/jpeg', 0.9);
    }

    retakeSnapshot() {
        this.currentBlob = null;
        if (this.snapshotPreview.src) {
            URL.revokeObjectURL(this.snapshotPreview.src);
            this.snapshotPreview.src = '';
        }

        this.snapshotContainer.classList.add('hidden');
        this.guideOverlay.classList.remove('hidden');

        this.controlsSubmit.classList.add('hidden');
        this.controlsCapture.classList.remove('hidden');
    }

    async submitAttendance(endpoint, type) {
        if (!this.currentBlob) {
            this.showToast('Harap ambil foto terlebih dahulu.', 'error');
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!csrfToken) {
            this.showToast('CSRF Token tidak ditemukan.', 'error');
            return;
        }

        this.setSubmitting(true);

        const formData = new FormData();
        formData.append('photo', this.currentBlob, `snapshot-${Date.now()}.jpg`);
        formData.append('type', type);

        if (this.userLocation) {
            formData.append('latitude', this.userLocation.latitude);
            formData.append('longitude', this.userLocation.longitude);
        }

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok && data.success) {
                this.showToast(data.message || 'Presensi berhasil dicatat!', 'success');
                setTimeout(() => {
                    this.retakeSnapshot();
                }, 2000);
            } else {
                const errMsg = data.message || 'Gagal menyimpan absensi. Coba lagi.';
                this.showToast(errMsg, 'error');
            }
        } catch (error) {
            console.error('Submission network error:', error);
            this.showToast('Terjadi kesalahan jaringan saat mengirim absensi.', 'error');
        } finally {
            this.setSubmitting(false);
        }
    }

    setSubmitting(isSubmitting) {
        if (this.btnCheckin) this.btnCheckin.disabled = isSubmitting;
        if (this.btnCheckout) this.btnCheckout.disabled = isSubmitting;
        if (this.btnRetake) this.btnRetake.disabled = isSubmitting;

        if (isSubmitting) {
            this.updateStatus('connecting', 'Mengirim Data...');
        } else {
            this.updateStatus('active', 'Kamera Aktif');
        }
    }

    updateStatus(state, text) {
        if (!this.statusText || !this.statusIndicator) return;
        this.statusText.textContent = text;

        if (state === 'active') {
            this.statusIndicator.className = 'w-2 h-2 rounded-full bg-success';
        } else if (state === 'connecting') {
            this.statusIndicator.className = 'w-2 h-2 rounded-full bg-warning animate-pulse';
        } else {
            this.statusIndicator.className = 'w-2 h-2 rounded-full bg-danger';
        }
    }

    showError(message) {
        this.updateStatus('error', 'Kamera Terputus');
        if (this.btnCapture) this.btnCapture.disabled = true;
        if (this.errorMessage) this.errorMessage.textContent = message;
        if (this.errorBox) this.errorBox.classList.remove('hidden');
    }

    showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        const toast = document.createElement('div');
        const isSuccess = type === 'success';
        toast.className = `p-3.5 rounded-md text-sm font-semibold shadow-lg transition-all duration-300 transform translate-y-2 opacity-0 flex items-center justify-between pointer-events-auto ${
            isSuccess ? 'bg-success text-on-success' : 'bg-danger text-on-danger'
        }`;

        toast.innerHTML = `
            <div class="flex items-center gap-2">
                <span>${isSuccess ? '✓' : '⚠'}</span>
                <span>${message}</span>
            </div>
            <button class="ml-3 text-white/80 hover:text-white font-bold text-xs" onclick="this.parentElement.remove()">✕</button>
        `;

        container.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        });

        // Auto remove after 4 seconds
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    initGeolocation() {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    this.userLocation = {
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude
                    };
                },
                (err) => {
                    // Geolocation optional fallback
                    console.log('Location access not granted:', err.message);
                },
                { timeout: 8000 }
            );
        }
    }

    initClock() {
        const clockEl = document.getElementById('live-clock');
        if (!clockEl) return;

        setInterval(() => {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour12: false }) + ' <span class="text-xs text-on-surface-muted font-medium">WIB</span>';
            clockEl.innerHTML = timeStr;
        }, 1000);
    }
}

// Auto-instantiate when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.webcamAttendance = new WebcamAttendance();
});

export default WebcamAttendance;
