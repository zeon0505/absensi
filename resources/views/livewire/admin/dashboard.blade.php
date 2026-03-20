@php
    /** @var array $stats */
    /** @var array $chartLabels */
    /** @var array $chartData */
    /** @var iterable $recent_attendances */
@endphp

<div class="space-y-8 animate-in fade-in duration-500">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-[26px] font-semibold text-slate-800 dark:text-slate-100 tracking-tight">Ringkasan Sistem</h2>
            <p class="text-[14px] text-slate-500 dark:text-slate-400 mt-1">Pantau perkembangan absensi dan statistik harian Anda.</p>
        </div>
        <div class="flex items-center space-x-4 bg-white dark:bg-slate-900 px-5 py-3 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <div class="w-11 h-11 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center font-semibold text-xl">
                {{ date('d') }}
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none">{{ date('l') }}</p>
                <p class="text-[15px] font-medium text-slate-700 dark:text-slate-200 mt-1.5">{{ date('F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Stats Grid (Dark Mode Compatible) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ['label' => 'Total Staff', 'value' => $stats['total_users'] ?? 0, 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'indigo', 'desc' => 'Aktif'],
                ['label' => 'Hadir Hari Ini', 'value' => $stats['present_today'] ?? 0, 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'emerald', 'desc' => 'Tercatat'],
                ['label' => 'Staff Online', 'value' => $stats['online_now'] ?? 0, 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'color' => 'emerald', 'desc' => 'Saat Ini'],
                ['label' => 'Izin Pending', 'value' => $stats['pending_leaves'] ?? 0, 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'rose', 'desc' => 'Proses'],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white dark:bg-slate-900 p-7 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm transition-all hover:border-{{ $card['color'] }}-100 dark:hover:border-{{ $card['color'] }}-900 group">
            <div class="flex items-center justify-between mb-5">
                <div class="w-12 h-12 bg-{{ $card['color'] }}-50 dark:bg-{{ $card['color'] }}-900/20 text-{{ $card['color'] }}-600 dark:text-{{ $card['color'] }}-400 rounded-xl flex items-center justify-center transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"></path></svg>
                </div>
                <span class="text-[11px] font-semibold text-{{ $card['color'] }}-500 dark:text-{{ $card['color'] }}-400 uppercase tracking-widest px-2.5 py-1 bg-{{ $card['color'] }}-50/50 dark:bg-{{ $card['color'] }}-900/10 rounded-lg">{{ $card['desc'] }}</span>
            </div>
            <p class="text-[13px] font-medium text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">{{ $card['label'] }}</p>
            <h3 class="text-3xl font-semibold text-slate-800 dark:text-slate-100 tracking-tight">{{ $card['value'] }}</h3>
        </div>
        @endforeach
    </div>

    <!-- Main Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm p-8 lg:p-10">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center space-x-4">
                    <div class="w-1.5 h-6 bg-indigo-600 dark:bg-indigo-400 rounded-full"></div>
                    <h3 class="text-[18px] font-semibold text-slate-800 dark:text-slate-100">Tren Kehadiran</h3>
                </div>
                
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center space-x-3 px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[14px] text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-750 transition-colors focus:outline-none ring-2 ring-transparent focus:ring-indigo-50 dark:focus:ring-indigo-900/20">
                        <span class="font-medium">{{ $chartRange == '7' ? '7 Hari Terakhir' : '30 Hari Terakhir' }}</span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-cloak x-transition.opacity class="absolute right-0 mt-3 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 z-30">
                        <button wire:click="$set('chartRange', '7')" @click="open = false" class="w-full flex items-center px-4 py-2.5 text-[13px] text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition-colors {{ $chartRange == '7' ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 font-semibold' : 'font-normal' }}">
                            7 Hari Terakhir
                        </button>
                        <button wire:click="$set('chartRange', '30')" @click="open = false" class="w-full flex items-center px-4 py-2.5 text-[13px] text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl transition-colors {{ $chartRange == '30' ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 font-semibold' : 'font-normal' }}">
                            30 Hari Terakhir
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="h-[350px] w-full relative">
                <canvas id="attendanceChart" class="w-full"></canvas>
            </div>
        </div>

        <!-- Recent Logs -->
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col overflow-hidden">
            <div class="p-8 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-[14px] font-semibold text-slate-800 dark:text-slate-100 uppercase tracking-widest">Aktivitas Terkini</h3>
            </div>
            <div class="flex-grow overflow-y-auto p-5 space-y-4 custom-scrollbar max-h-[480px]">
                @if(isset($recent_attendances))
                    @forelse($recent_attendances as $logs)
                        <div class="flex items-center space-x-4 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all rounded-2xl border border-transparent">
                            <div class="relative shrink-0">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center text-base font-semibold shadow-sm">
                                    {{ strtoupper(substr($logs->user->name ?? '?', 0, 1)) }}
                                </div>
                                @if($logs->user->isOnline())
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full animate-pulse"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[15px] font-medium text-slate-700 dark:text-slate-200 truncate leading-tight tracking-tight">{{ $logs->user->name ?? 'User' }}</p>
                                <div class="flex items-center space-x-2.5 mt-2">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $logs->status == 'hadir' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400' }}">
                                        {{ strtoupper($logs->status) }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">{{ $logs->check_in }} — {{ date('d M') }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-24 text-center">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-slate-300 dark:text-slate-600 text-[13px] font-medium tracking-wider uppercase">Belum ada aktivitas</p>
                        </div>
                    @endforelse
                @endif
            </div>
            <div class="p-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/10 dark:bg-slate-800/10">
                <a href="{{ route('admin.reports') }}" wire:navigate class="block w-full text-center py-4 text-[12px] font-bold text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all uppercase tracking-[0.2em] border border-slate-100 dark:border-slate-700 rounded-xl hover:bg-white dark:hover:bg-slate-800 shadow-sm">Lihat Laporan Detail</a>
            </div>
        </div>
    </div>

    <!-- Chart Logic -->
    <script>
        function getChartConfig() {
            const isDark = document.documentElement.classList.contains('dark');
            const color = isDark ? '#818cf8' : '#6366f1';
            const gridColor = isDark ? '#1e293b' : '#f1f5f9';
            const textColor = isDark ? '#64748b' : '#94a3b8';

            return { color, gridColor, textColor };
        }

        function renderDashboardChart() {
            const canvas = document.getElementById('attendanceChart');
            if (!canvas) return;

            if (window.myDashboardChart) { window.myDashboardChart.destroy(); }

            const ctx = canvas.getContext('2d');
            const config = getChartConfig();
            
            window.myDashboardChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartLabels ?? []) !!},
                    datasets: [{
                        label: 'Hadir',
                        data: {!! json_encode($chartData ?? []) !!},
                        borderColor: config.color,
                        backgroundColor: config.color + (config.color === '#818cf8' ? '15' : '05'),
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: config.color,
                        pointBorderWidth: 4,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 14, weight: '600', family: 'Outfit' },
                            bodyFont: { size: 13, weight: '400', family: 'Outfit' },
                            padding: 16,
                            cornerRadius: 14,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: config.gridColor, drawBorder: false },
                            ticks: { 
                                color: config.textColor, 
                                font: { weight: '500', size: 12, family: 'Outfit' },
                                stepSize: 1,
                                padding: 12
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { 
                                color: config.textColor, 
                                font: { weight: '500', size: 12, family: 'Outfit' },
                                padding: 12
                            }
                        }
                    }
                }
            });
        }

        // Handle Dark Mode Switch for Chart
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    renderDashboardChart();
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });

        document.addEventListener('livewire:navigated', renderDashboardChart);
        document.addEventListener('DOMContentLoaded', renderDashboardChart);
        setTimeout(renderDashboardChart, 100);
    </script>
</div>
