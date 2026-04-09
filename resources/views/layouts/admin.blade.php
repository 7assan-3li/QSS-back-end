<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>QSS Admin | @yield('title', 'Analytics')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Init theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const iconElement = document.getElementById('theme-icon');
            if (iconElement) {
                // Update icon based on theme
                iconElement.innerHTML = document.documentElement.classList.contains('dark') 
                    ? '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 16.243l.707.707M7.757 7.757l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>'
                    : '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>';
            }
        }

        document.addEventListener('DOMContentLoaded', updateThemeIcon);

        /**
         * Premium Confirmation Helper (High Impact Edition)
         * Integrates with SweetAlert2 with specialized "Danger Mode" for deletions
         */
        function confirmAction(formId, config = {}) {
            const isDark = document.documentElement.classList.contains('dark');
            const isDanger = config.isDanger || config.icon === 'warning';
            
            const confirmColor = isDanger ? '#e11d48' : '#4f46e5';
            const defaultText = config.text || (isDanger ? "{{ __('تنبيه: أنت على وشك القيام بعملية مسح نهائية لا يمكن التراجع عنها!') }}" : "{{ __('هل أنت متأكد من القيام بهذه العملية الحساسة؟') }}");
            const defaultTitle = config.title || (isDanger ? "⚠️ {{ __('تأكيد الحذف النهائي') }}" : "{{ __('تأكيد إجراء إداري') }}");
            const confirmButtonText = config.confirmButtonText || (isDanger ? "{{ __('تأكيد المسح الآن') }}" : "{{ __('تأكيد التنفيذ') }}");
            const cancelButtonText = config.cancelButtonText || "{{ __('إلغاء') }}";

            Swal.fire({
                title: defaultTitle,
                text: defaultText,
                icon: config.icon || (isDanger ? 'warning' : 'info'),
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: isDark ? '#1e293b' : '#94a3b8',
                confirmButtonText: confirmButtonText,
                cancelButtonText: cancelButtonText,
                background: isDark ? '#0f172a' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                backdrop: isDanger ? 'rgba(225, 29, 72, 0.1)' : 'rgba(0,0,0,0.4)',
                showClass: {
                    popup: isDanger ? 'swal2-head-shake' : 'swal2-show'
                },
                customClass: {
                    popup: `rounded-[2.5rem] border ${isDanger ? 'border-rose-500 shadow-rose-500/10' : 'border-slate-100 dark:border-slate-800 shadow-2xl'} font-Cairo`,
                    title: 'font-black text-2xl font-Cairo !text-inherit',
                    htmlContainer: 'font-bold text-sm font-Cairo opacity-60',
                    confirmButton: `px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-transform hover:scale-105 active:scale-95 font-Cairo shadow-lg ${isDanger ? 'shadow-rose-500/20' : 'shadow-indigo-500/20'}`,
                    cancelButton: 'px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest transition-transform hover:scale-105 active:scale-95 font-Cairo'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (form) form.submit();
                }
            });
        }

        /**
         * Universal CSV Export Utility (Enterprise Version)
         * Supports Arabic characters and cleans data for Excel compatibility.
         */
        window.exportTableToCSV = function(tableId, filename) {
            let csv = [];
            const table = document.getElementById(tableId) || document.querySelector('table');
            if (!table) return;
            
            const rows = table.querySelectorAll(`tr`);
            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll("td, th");
                // Skip rows without columns (like empty states)
                if (cols.length === 0) continue;
                
                for (let j = 0; j < cols.length; j++) {
                    // Skip action columns usually containing buttons/links (if they have no text or specific classes)
                    if (cols[j].classList.contains('text-center') && i > 0 && cols[j].querySelector('a, button')) {
                        // Optional: skip action column if desired. For now, we take text.
                    }
                    
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, "").replace(/(\s\s+)/gm, " ");
                    row.push('"' + data.trim() + '"');
                }
                csv.push(row.join(","));
            }
            
            const BOM = "\uFEFF";
            const csvData = BOM + csv.join("\n");
            const csvFile = new Blob([csvData], {type: "text/csv;charset=utf-8;"});
            const downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = "none";
            document.body.appendChild(downloadLink);
            downloadLink.click();
        }
    </script>
    
    <style>
        @keyframes swal2-head-shake {
            0% { transform: translateX(0); }
            6.5% { transform: translateX(-6px) rotateY(-9deg); }
            18.5% { transform: translateX(5px) rotateY(7deg); }
            31.5% { transform: translateX(-3px) rotateY(-5deg); }
            43.5% { transform: translateX(2px) rotateY(3deg); }
            50% { transform: translateX(0); }
        }
        .swal2-head-shake {
            animation: swal2-head-shake 0.6s ease-in-out;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-2xl border border-slate-100 dark:border-slate-800 font-Cairo shadow-2xl'
                }
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                background: isDark ? '#1e293b' : '#ffffff',
                color: isDark ? '#f8fafc' : '#1e293b',
                customClass: {
                    popup: 'rounded-2xl border border-rose-500/20 font-Cairo shadow-2xl'
                }
            });
        });
    </script>
    @endif

    @stack('styles')
</head>
<body class="font-sans antialiased text-slate-900 dark:text-slate-100 h-screen flex overflow-hidden relative selection:bg-brand-primary selection:text-white">

    <!-- Ambient Glow Backgrounds -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="ambient-glow bg-brand-primary/10 w-[500px] h-[500px] -top-48 -right-48 rounded-full transition-all duration-1000"></div>
        <div class="ambient-glow bg-brand-secondary/10 w-[600px] h-[600px] -bottom-64 -left-64 rounded-full transition-all duration-1000"></div>
    </div>
    
    <!-- Sidebar Partial -->
    @include('partials.admin.sidebar')

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col relative z-20 w-full overflow-hidden bg-[var(--main-bg)] transition-colors duration-500">
        
        <!-- Header Partial -->
        @include('partials.admin.header')

        <!-- Dynamic Content -->
        <div class="flex-1 overflow-y-auto px-4 md:px-8 pb-8 custom-scrollbar relative z-10 bg-[var(--main-bg)]">
            @yield('content')
        </div>

    </main>

    @stack('scripts')
</body>
</html>
