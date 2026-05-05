@extends('layouts.admin')

@section('title', __('ط¥ط¯ط§ط±ط© ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ†'))

@section('content')
<div class="max-w-7xl mx-auto space-y-12 mt-4 animate-fade-in text-start font-Cairo">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-8 text-start">
        <div class="text-start">
            <h3 class="font-black text-3xl flex items-center gap-4 text-start font-Cairo">
                <span class="w-16 h-16 bg-brand-primary-500/10 rounded-2xl flex items-center justify-center text-brand-primary-600 text-3xl font-Cairo shadow-lg shadow-brand-primary-500/5 whitespace-nowrap inline-flex items-center justify-center">ًں‘¥</span>
                {{ __('ط³ط¬ظ„ ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ†') }}
            </h3>
            <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 mr-20 text-start font-Cairo">
                {{ __('ط¥ط¯ط§ط±ط© ط¨ظٹط§ظ†ط§طھ ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ†طŒ ظ…ط±ط§ظ‚ط¨ط© ط§ظ„طھط³ط¬ظٹظ„ط§طھطŒ ظˆطھط¹ط¯ظٹظ„ ط§ظ„طµظ„ط§ط­ظٹط§طھ.') }}
            </p>
        </div>
        <div class="px-8 py-3 bg-brand-primary-500/10 rounded-2xl border border-brand-primary-500/20 text-brand-primary-600 text-[13px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm animate-pulse text-start">
            {{ __('ظ…ط¹ط¯ظ„ ط§ظ„ظ†ظ…ظˆ ط§ظ„ظ„ط­ط¸ظٹ: ظ†ط´ط·') }} ًں“ٹ
        </div>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-start">
        <!-- Total Users -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group text-start">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-primary-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] font-Cairo text-start">{{ __('ط¥ط¬ظ…ط§ظ„ظٹ ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ†') }}</span>
                <div class="flex items-baseline gap-3 text-start">
                    <span class="text-4xl font-black leading-none font-mono italic text-start">{{ number_format($users->count()) }}</span>
                    <span class="text-[13px] font-black text-brand-primary-500 font-Cairo italic text-start">{{ __('ظ…ط³طھط®ط¯ظ…') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[13px] font-black text-brand-primary-500 font-Cairo text-start">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                <span>{{ __('ط¥ط¬ظ…ط§ظ„ظٹ ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ† ط§ظ„ظ…ط³ط¬ظ„ظٹظ† ظپظٹ ط§ظ„ظ†ط¸ط§ظ…') }}</span>
            </div>
        </div>

        <!-- Today's New Users -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group font-Cairo text-start">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-primary-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ† ط§ظ„ط¬ط¯ط¯ ط§ظ„ظٹظˆظ…') }}</span>
                <div class="flex items-baseline gap-3 text-start">
                    <span class="text-4xl font-black leading-none font-mono italic text-start">{{ number_format($todayUsers) }}</span>
                    <span class="text-[13px] font-black text-brand-primary-500 italic text-start font-Cairo">{{ __('ط¹ط¶ظˆ ط¬ط¯ظٹط¯') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[13px] font-black text-[var(--text-muted)] tracking-[0.2em] font-Cairo uppercase text-start">
                <span>{{ __('ط¢ط®ط± 24 ط³ط§ط¹ط©') }}</span>
            </div>
        </div>

        <!-- Weekly New Users -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group font-Cairo text-start">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start font-Cairo">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('ظ…ظ†ط¶ظ…ظٹ ظ‡ط°ط§ ط§ظ„ط£ط³ط¨ظˆط¹') }}</span>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black leading-none font-mono italic text-start">{{ number_format($weekUsers) }}</span>
                    <span class="text-[13px] font-black text-amber-500 italic text-start font-Cairo">{{ __('ظ…ط³طھط®ط¯ظ…') }}</span>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[13px] font-black text-[var(--text-muted)] tracking-[0.2em] uppercase text-start font-Cairo">
                <span>{{ __('ط®ظ„ط§ظ„ ط¢ط®ط± 7 ط£ظٹط§ظ…') }}</span>
            </div>
        </div>

        <!-- Monthly Growth -->
        <div class="card-premium glass-panel p-8 relative overflow-hidden group font-Cairo text-start">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-rose-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>
            <div class="flex flex-col gap-2 relative z-10 text-start font-Cairo">
                <span class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.3em] text-start font-Cairo">{{ __('ظ†ط³ط¨ط© ط§ظ„ظ†ظ…ظˆ ط§ظ„ط´ظ‡ط±ظٹ') }}</span>
                <div class="flex items-baseline gap-3 text-start font-Cairo">
                    <span class="text-4xl font-black leading-none font-mono italic text-start">{{ $growth }}%</span>
                    <svg class="w-6 h-6 text-brand-primary-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <div class="mt-6 flex items-center gap-2 text-[13px] font-black text-[var(--text-muted)] tracking-[0.2em] uppercase text-start font-Cairo">
                <span>{{ __('ظ…ظ‚ط§ط±ظ†ط© ط¨ط§ظ„ط´ظ‡ط± ط§ظ„ط³ط§ط¨ظ‚') }}</span>
            </div>
        </div>
    </div>

    <!-- Growth & Role Analysis -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 font-Cairo text-start">
        <div class="lg:col-span-8 card-premium glass-panel p-10 text-start font-Cairo">
            <div class="flex items-center justify-between mb-10 text-start font-Cairo">
                <div class="text-start font-Cairo">
                    <h4 class="text-xl font-black font-Cairo text-start italic">{{ __('ط§ظ„ظ…ط³ط§ط± ط§ظ„ط¨ظٹط§ظ†ظٹ ظ„ظ„ظ†ظ…ظˆ ط§ظ„ط³ظ†ظˆظٹ') }}</h4>
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mt-2 font-Cairo text-start">{{ __('طھطھط¨ط¹ ط§ظ†ط¶ظ…ط§ظ… ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ† ط®ظ„ط§ظ„ ط§ظ„ط¹ط§ظ… ط§ظ„ط¬ط§ط±ظٹ.') }}</p>
                </div>
                <div class="p-4 bg-brand-primary-500/10 rounded-2xl text-brand-primary-600 shadow-sm font-Cairo"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg></div>
            </div>
            <div class="h-[350px] font-Cairo">
                <canvas id="usersChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-4 card-premium glass-panel p-10 text-start font-Cairo">
            <div class="flex items-center justify-between mb-10 text-start font-Cairo">
                <div class="text-start font-Cairo">
                    <h4 class="text-xl font-black font-Cairo text-start italic">{{ __('طھظˆط²ظٹط¹ ط§ظ„ط£ط¯ظˆط§ط±') }}</h4>
                    <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-widest mt-2 font-Cairo text-start">{{ __('طھظˆط²ظٹط¹ ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ† ط­ط³ط¨ ظ†ظˆط¹ ط§ظ„ط­ط³ط§ط¨.') }}</p>
                </div>
                <div class="p-4 bg-purple-500/10 rounded-2xl text-purple-600 shadow-sm font-Cairo"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg></div>
            </div>
            <div class="h-[300px] flex justify-center items-center font-Cairo">
                <canvas id="rolesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- User List Table -->
    <div class="card-premium glass-panel rounded-[4.5rem] shadow-2xl border border-[var(--glass-border)] overflow-hidden font-Cairo text-start">
        <div class="p-12 border-b border-[var(--glass-border)] flex flex-col md:flex-row justify-between items-center gap-8 text-start">
            <div class="text-start">
                <h4 class="text-2xl font-black font-Cairo text-start italic">{{ __('ظ‚ط§ط¦ظ…ط© ط¥ط¯ط§ط±ط© ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ†') }}</h4>
                <p class="text-[13px] font-black text-[var(--text-muted)] uppercase tracking-[0.2em] mt-3 text-start font-Cairo">{{ __('ط¹ط±ط¶ ظˆطھط¹ط¯ظٹظ„ ط¨ظٹط§ظ†ط§طھ ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ† ظˆط§ظ„طھط­ظƒظ… ظپظٹ طµظ„ط§ط­ظٹط§طھظ‡ظ….') }}</p>
            </div>
            <div class="flex items-center gap-4 text-start font-Cairo">
                <a href="{{ route('users.create') }}" class="bg-brand-primary text-white px-8 py-3 rounded-2xl text-[13px] font-black uppercase tracking-[0.2em] font-Cairo shadow-lg shadow-brand-primary/20 hover:scale-105 transition-all whitespace-nowrap inline-flex items-center justify-center gap-2 italic">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('ط¥ط¶ط§ظپط© ظ…ط³طھط®ط¯ظ… ط¬ط¯ظٹط¯') }}
                </a>
                <span class="bg-brand-primary-500/10 text-brand-primary-600 px-6 py-3 rounded-2xl text-[13px] font-black uppercase tracking-[0.2em] font-Cairo shadow-sm whitespace-nowrap inline-flex items-center justify-center">{{ __('ط¥ط¯ط§ط±ط© ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ†') }}</span>
            </div>
        </div>
        
        <div class="overflow-x-auto text-start font-Cairo">
            <table class="w-full text-start border-collapse font-Cairo">
                <thead>
                    <tr class="bg-[var(--main-bg)] border-b border-[var(--glass-border)] text-start font-Cairo">
                        <th class="table-header-cell">{{ __('ط§ظ„ظ…ط³ظ„ط³ظ„') }}</th>
                        <th class="table-header-cell">{{ __('ط¨ظٹط§ظ†ط§طھ ط§ظ„ظ…ط³طھط®ط¯ظ…') }}</th>
                        <th class="table-header-cell">{{ __('ظ†ظˆط¹ ط§ظ„ط­ط³ط§ط¨ / ط§ظ„ط¯ظˆط±') }}</th>
                        <th class="table-header-cell">{{ __('طھط§ط±ظٹط® ط§ظ„طھط³ط¬ظٹظ„') }}</th>
                        <th class="table-header-cell">{{ __('ط§ظ„ط­ط§ظ„ط©') }}</th>
                        <th class="table-header-cell text-center">{{ __('ط§ظ„ط¥ط¬ط±ط§ط،ط§طھ') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--glass-border)] text-start font-Cairo">
                    @forelse ($users as $user)
                        <tr class="hover:bg-brand-primary/[0.02] dark:hover:bg-brand-primary/[0.03] transition-all group font-Cairo text-start">
                            <td class="px-10 py-8 text-start text-[13px] font-black text-[var(--text-muted)] font-mono italic text-start">
                                #{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-10 py-8 text-start">
                                <div class="flex items-center gap-5 text-start font-Cairo">
                                    <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 flex items-center justify-center text-brand-primary font-black text-xs border border-[var(--glass-border)] shadow-sm group-hover:scale-110 transition-transform font-mono italic">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="flex flex-col text-start font-Cairo">
                                        <span class="text-[13px] font-black font-Cairo leading-none mb-2 italic text-start">{{ $user->name }}</span>
                                        <span class="text-[13px] font-bold text-[var(--text-muted)] font-mono tracking-wide text-start italic">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-start">
                                @php
                                    $roleBadge = match($user->role) {
                                        \App\constant\Role::ADMIN => 'badge-status-admin',
                                        \App\constant\Role::EMPLOYEE => 'badge-status-admin',
                                        \App\constant\Role::PROVIDER => 'badge-status-success',
                                        \App\constant\Role::SEEKER   => 'badge-status-info',
                                        default => 'badge-status'
                                    };
                                    $roleName = match($user->role) {
                                        \App\constant\Role::EMPLOYEE => __('ظ…ظˆط¸ظپ'),
                                        \App\constant\Role::PROVIDER => __('ظ…ط²ظˆط¯ ط®ط¯ظ…ط©'),
                                        \App\constant\Role::SEEKER   => __('ط·ط§ظ„ط¨ ط®ط¯ظ…ط©'),
                                        default => $user->role
                                    };
                                @endphp
                                <span class="badge-status {{ $roleBadge }} italic">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-start">
                                <span class="text-[13px] font-black text-[var(--text-muted)] font-mono tracking-[0.2em] text-start italic">{{ $user->created_at->format('Y-m-d') }}</span>
                            </td>
                            <td class="px-10 py-8 text-start">
                                @if($user->status === 'active')
                                    <span class="badge-status badge-status-success italic">
                                        {{ __('ظ†ط´ط·') }}
                                    </span>
                                @else
                                    <span class="badge-status badge-status-danger italic">
                                        {{ __('ظ…ظˆظ‚ظˆظپ') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-10 py-8 text-center font-Cairo">
                                <div class="flex items-center justify-center gap-4 text-start font-Cairo">
                                    @can('view', $user)
                                        <a href="{{ route('users.show', $user->id) }}" class="btn-action btn-action-view" title="{{ __('ط¹ط±ط¶ ط§ظ„ظ…ظ„ظپ ط§ظ„ط´ط®طµظٹ') }}">
                                            <svg class="w-5 h-5 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                    @endcan

                                    @can('update', $user)
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn-action btn-action-edit" title="{{ __('طھط¹ط¯ظٹظ„ ط§ظ„ط¨ظٹط§ظ†ط§طھ') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    @endcan

                                    @can('suspend', $user)
                                        <form action="{{ route('users.toggle-status', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn-action {{ $user->status === 'active' ? 'btn-action-danger' : 'btn-action-success' }}" title="{{ $user->status === 'active' ? __('ط¥ظٹظ‚ط§ظپ ط§ظ„ط­ط³ط§ط¨') : __('طھظ†ط´ظٹط· ط§ظ„ط­ط³ط§ط¨') }}">
                                                @if($user->status === 'active')
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @endif
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-40 text-center font-Cairo text-start">
                                <div class="flex flex-col items-center opacity-30 gap-8 text-start font-Cairo">
                                    <div class="w-24 h-24 bg-[var(--glass-border)] rounded-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-[var(--text-muted)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <span class="text-sm font-black text-[var(--text-muted)] uppercase tracking-[0.2em]">{{ __('ظ„ط§ ظٹظˆط¬ط¯ ظ…ط³طھط®ط¯ظ…ظٹظ† ط­ط§ظ„ظٹط§ظ‹') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Chart Defaults
        Chart.defaults.font.family = 'Cairo, sans-serif';
        Chart.defaults.color = '#94a3b8';
        Chart.defaults.borderColor = 'rgba(148, 163, 184, 0.1)';
        
        /* Growth Chart */
        const ctxLine = document.getElementById('usersChart').getContext('2d');
        const gradientLine = ctxLine.createLinearGradient(0, 0, 0, 400);
        gradientLine.addColorStop(0, 'rgba(99, 102, 241, 0.15)');
        gradientLine.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($usersChart->keys()),
                datasets: [{
                    label: '{{ __('ط§ظ†ط¶ظ…ط§ظ… ط§ظ„ظ…ط³طھط®ط¯ظ…ظٹظ† ط´ظ‡ط±ظٹط§ظ‹') }}',
                    data: @json($usersChart->values()),
                    fill: true,
                    tension: 0.45,
                    backgroundColor: gradientLine,
                    borderColor: '#6366f1',
                    borderWidth: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#6366f1',
                    pointHoverBorderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 15,
                        displayColors: false,
                        cornerRadius: 12
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { weight: 'black', size: 10 } } },
                    y: { 
                        beginAtZero: true, 
                        grid: { color: 'rgba(148, 163, 184, 0.1)' },
                        ticks: { precision: 0, font: { weight: 'black', size: 10 } } 
                    }
                }
            }
        });

        /* Role Distribution Chart */
        new Chart(document.getElementById('rolesChart'), {
            type: 'doughnut',
            data: {
                labels: @json($rolesChart->keys()),
                datasets: [{
                    data: @json($rolesChart->values()),
                    backgroundColor: ['#6366f1', '#10b981', '#f59e0b', '#f43f5e'],
                    hoverBackgroundColor: ['#4f46e5', '#059669', '#d97706', '#e11d48'],
                    borderWidth: 0,
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: { 
                            padding: 25, 
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { weight: 'black', size: 10 }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 15,
                        cornerRadius: 12
                    }
                }
            }
        });
    </script>
@endpush
