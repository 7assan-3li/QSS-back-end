<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    public function migrate()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            return "<pre style='background: #0f172a; color: #34d399; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Migration executed successfully:\n\n" . htmlspecialchars($output) . "</pre>";
        } catch (\Exception $e) {
            return "<pre style='background: #0f172a; color: #ef4444; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Migration failed:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }

    public function migrateFresh()
    {
        try {
            Artisan::call('migrate:fresh', ['--force' => true]);
            $output = Artisan::output();
            return "<pre style='background: #0f172a; color: #34d399; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Migrate fresh executed successfully:\n\n" . htmlspecialchars($output) . "</pre>";
        } catch (\Exception $e) {
            return "<pre style='background: #0f172a; color: #ef4444; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Migrate fresh failed:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }

    public function dbSeed()
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();
            return "<pre style='background: #0f172a; color: #34d399; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Database seeding executed successfully:\n\n" . htmlspecialchars($output) . "</pre>";
        } catch (\Exception $e) {
            return "<pre style='background: #0f172a; color: #ef4444; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Database seeding failed:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }

    public function storageLink()
    {
        try {
            Artisan::call('storage:link');
            $output = Artisan::output();
            return "<pre style='background: #0f172a; color: #34d399; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Storage link executed successfully:\n\n" . htmlspecialchars($output) . "</pre>";
        } catch (\Exception $e) {
            return "<pre style='background: #0f172a; color: #ef4444; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Storage link failed:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }

    public function optimizeClear()
    {
        try {
            Artisan::call('optimize:clear');
            $output = Artisan::output();
            return "<pre style='background: #0f172a; color: #34d399; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Optimize clear executed successfully:\n\n" . htmlspecialchars($output) . "</pre>";
        } catch (\Exception $e) {
            return "<pre style='background: #0f172a; color: #ef4444; padding: 20px; border-radius: 10px; font-family: monospace; direction: ltr;'>Optimize clear failed:\n\n" . htmlspecialchars($e->getMessage()) . "</pre>";
        }
    }
}
