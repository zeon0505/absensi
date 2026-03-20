<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in duration-500" x-data="qrScanner()">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex items-center space-x-5">
            <div class="w-14 h-14 bg-indigo-600 text-white rounded-[1.25rem] flex items-center justify-center shadow-lg shadow-indigo-100 dark:shadow-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <h2 class="text-[24px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight leading-none">Scanner Absensi</h2>
                <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-2 font-medium">Arahkan kamera Anda ke Kode QR yang disediakan Admin.</p>
            </div>
        </div>
    </div>

    <!-- Scanner Area -->
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 border border-slate-100 dark:border-slate-800 shadow-sm transition-colors relative overflow-hidden">
        <div class="max-w-md mx-auto space-y-8">
            
            <!-- Camera Preview Container -->
            <div class="relative group">
                <!-- Decorative Frame -->
                <div class="absolute -inset-2 bg-gradient-to-tr from-indigo-500 to-violet-500 rounded-[3rem] opacity-20 blur-sm group-hover:opacity-30 transition-opacity"></div>
                
                <div class="relative z-10 bg-slate-950 rounded-[2.5rem] overflow-hidden aspect-square shadow-2xl border-4 border-white dark:border-slate-800">
                    <div id="reader" class="w-full h-full"></div>
                    
                    <!-- Overlay Scanner Anim -->
                    <div x-show="scanning" class="absolute inset-0 pointer-events-none z-20 flex flex-col items-center justify-center">
                        <div class="w-2/3 h-2/3 border-2 border-dashed border-indigo-400/50 rounded-3xl animate-pulse flex items-center justify-center">
                            <div class="w-full border-b-2 border-indigo-500/50 absolute top-1/2 -translate-y-1/2 animate-scan-line"></div>
                        </div>
                    </div>

                    <!-- Placeholder/Loading -->
                    <div x-show="!cameraReady" class="absolute inset-0 flex flex-col items-center justify-center space-y-4 bg-slate-900 z-30">
                        <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                        <p class="text-[12px] font-bold text-slate-400 uppercase tracking-widest">Inisialisasi Kamera...</p>
                    </div>
                </div>
            </div>

            <!-- Controls & Feedback -->
            <div class="space-y-6 text-center">
                <div class="inline-flex items-center space-x-3 px-6 py-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-2xl">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500" :class="scanning ? 'animate-pulse' : ''"></span>
                    <p class="text-[13px] font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-[0.1em]" x-text="scanning ? 'Kamera Aktif' : 'Kamera Mati'"></p>
                </div>

                <div x-show="message" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    :class="messageType === 'success' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 border-emerald-100' : 'bg-rose-50 dark:bg-rose-900/20 text-rose-600 border-rose-100'"
                    class="p-4 rounded-2xl border text-[14px] font-semibold"
                    x-text="message">
                </div>

                <div class="pt-4 flex gap-4">
                    <button @click="startScanner" x-show="!scanning" class="flex-1 bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 transition-all shadow-lg uppercase tracking-widest text-[12px]">Buka Kamera</button>
                    <button @click="stopScanner" x-show="scanning" class="flex-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold py-4 rounded-2xl hover:bg-slate-200 transition-all uppercase tracking-widest text-[12px]">Tutup Kamera</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Library & Scripts -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        @keyframes scan-line {
            0% { top: 20%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 80%; opacity: 0; }
        }
        .animate-scan-line {
            animation: scan-line 2s infinite linear;
            position: absolute;
            width: 100%;
        }
        #reader__dashboard_section_csr { display: none !important; }
        #reader video { 
            object-fit: cover !important; 
            border-radius: 2rem;
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <script>
        function qrScanner() {
            return {
                html5QrCode: null,
                scanning: false,
                cameraReady: false,
                message: '',
                messageType: 'success',
                
                init() {
                    this.html5QrCode = new Html5Qrcode("reader");
                    
                    window.addEventListener('qrSuccess', (e) => {
                        this.message = e.detail[0];
                        this.messageType = 'success';
                        this.stopScanner();
                        setTimeout(() => this.message = '', 5000);
                    });

                    window.addEventListener('qrError', (e) => {
                        this.message = e.detail[0];
                        this.messageType = 'error';
                        setTimeout(() => this.message = '', 3000);
                    });
                },

                startScanner() {
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };
                    
                    this.html5QrCode.start(
                        { facingMode: "environment" }, 
                        config, 
                        (decodedText) => {
                            // On success
                            this.scanning = false;
                            Livewire.dispatch('processQrCode', { code: decodedText });
                        },
                        (errorMessage) => {
                            // On failure (ignore usually)
                        }
                    ).then(() => {
                        this.scanning = true;
                        this.cameraReady = true;
                    }).catch(err => {
                        console.error("Camera fail", err);
                        alert("Gagal mengakses kamera. Mohon berikan izin kamera.");
                    });
                },

                stopScanner() {
                    if (this.html5QrCode && this.scanning) {
                        this.html5QrCode.stop().then(() => {
                            this.scanning = false;
                            this.cameraReady = false;
                        });
                    }
                }
            }
        }
    </script>
</div>
