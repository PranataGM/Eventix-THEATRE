<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Acara Mendatang', Event::where('event_date', '>=', now())->count())
                ->description('Acara aktif yang sedang dikelola')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('success'),
            
            Stat::make('Total Registrasi', Registration::where('payment_status', 'paid')->orWhere('status', 'confirmed')->count())
                ->description('Tiket terjual di semua acara')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('primary')
                ->chart([7, 2, 10, 3, 15, 4, 17]), // Dummy chart trend
                
            Stat::make('Peserta Hadir (Check-In)', Registration::where('is_checked_in', true)->count())
                ->description('Orang yang telah hadir di lokasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),
        ];
    }
}
