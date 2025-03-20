<?php

namespace App\Http\Controllers;


use App\Models\Manager;
use App\Models\Company;
use App\Enums\OrderStatus;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard.Admin.dashboard');
    }

    public function switchLang()
    {
        $lang = match (app()->getLocale()) {
            'ar'    => 'en',
            'en'    => 'ar',
        };

        Session::put('lang', $lang);
        return redirect()->back();
    }


    // public function settings()
    // {
    //     $settings = Setting::paginate();
    //     return view('Dashboard.Admin.Settings.index', compact('settings'));
    // }

    // public function updateSettings(Request $request, string $settingId)
    // {
    //     $setting =  Setting::findOrFail($settingId);

    //     $setting->update(['value' => $request->value]);

    //     Session::flash('successMessage', translate('Updated successfully'));
    //     return redirect()->back();
    // }


    public function backupDatabase()
    {
        // Set the database credentials
        $host     = env('DB_HOST');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        // Set the path for the exported file
        $filename = env('APP_NAME') . '_' . date('Y-m-d_H-i-s') . '.sql';
        $path = storage_path('app/' . $filename);

        // Use mysqldump to export the database
        $command = sprintf(
            'mysqldump -h%s -u%s -p%s %s',
            $host,
            $username,
            $password,
            $database
        );

        $process = Process::fromShellCommandline($command);

        try {
            // Run the command
            $output = $process->mustRun()->getOutput();

            // Write the output to the file
            file_put_contents($path, $output);

            // Return the file for download
            return response()->download($path, $filename)->deleteFileAfterSend(true);
        } catch (ProcessFailedException $exception) {
            throw new \RuntimeException($exception->getMessage());
        }
    }
}
