<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class DeployController extends Controller
{
    /**
     * Check authorization using security token or admin session.
     */
    protected function authorizeAccess(Request $request): bool
    {
        $secret = env('DEPLOY_SECRET', 'alfaprima-deploy');
        $token = $request->query('token') ?? $request->input('token');

        if (!empty($secret) && $token === $secret) {
            return true;
        }

        if (Auth::check() && Auth::user()?->role === 'admin') {
            return true;
        }

        return false;
    }

    /**
     * Main deployment dashboard UI.
     */
    public function index(Request $request)
    {
        if (!$this->authorizeAccess($request)) {
            return response()->view('deploy.unauthorized', [
                'tokenProvided' => $request->query('token') !== null,
            ], 403);
        }

        $token = $request->query('token', env('DEPLOY_SECRET', 'alfaprima-deploy'));

        return view('deploy.index', [
            'token' => $token,
            'dbHost' => config('database.connections.mysql.host', '127.0.0.1'),
            'dbDatabase' => config('database.connections.mysql.database', 'alfaprima'),
            'appEnv' => config('app.env'),
        ]);
    }

    /**
     * Execute an artisan command safely with --force.
     */
    public function runCommand(Request $request, string $action)
    {
        if (!$this->authorizeAccess($request)) {
            return response()->view('deploy.unauthorized', [], 403);
        }

        $token = $request->query('token', env('DEPLOY_SECRET', 'alfaprima-deploy'));
        $output = '';
        $commandName = '';
        $success = true;

        try {
            switch ($action) {
                case 'migrate':
                    $commandName = 'php artisan migrate --force';
                    Artisan::call('migrate', ['--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'seed':
                    $commandName = 'php artisan db:seed --force';
                    Artisan::call('db:seed', ['--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'migrate-seed':
                    $commandName = 'php artisan migrate --force && php artisan db:seed --force';
                    Artisan::call('migrate', ['--force' => true]);
                    $output .= "=== MIGRATION OUTPUT ===\n" . Artisan::output() . "\n\n";
                    Artisan::call('db:seed', ['--force' => true]);
                    $output .= "=== SEEDER OUTPUT ===\n" . Artisan::output();
                    break;

                case 'migrate-fresh-seed':
                    $commandName = 'php artisan migrate:fresh --seed --force';
                    Artisan::call('migrate:fresh', ['--seed' => true, '--force' => true]);
                    $output = Artisan::output();
                    break;

                case 'optimize':
                    $commandName = 'php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache';
                    Artisan::call('optimize:clear');
                    $output .= "=== OPTIMIZE CLEAR ===\n" . Artisan::output() . "\n\n";
                    Artisan::call('config:cache');
                    $output .= "=== CONFIG CACHE ===\n" . Artisan::output() . "\n\n";
                    Artisan::call('route:cache');
                    $output .= "=== ROUTE CACHE ===\n" . Artisan::output() . "\n\n";
                    Artisan::call('view:cache');
                    $output .= "=== VIEW CACHE ===\n" . Artisan::output();
                    break;

                case 'storage-link':
                    $commandName = 'php artisan storage:link';
                    Artisan::call('storage:link');
                    $output = Artisan::output();
                    break;

                default:
                    return redirect()->route('deploy.index', ['token' => $token])
                        ->with('error', 'Aksi tidak dikenali.');
            }
        } catch (\Throwable $e) {
            $success = false;
            $output = "ERROR EXECUTING COMMAND:\n" . $e->getMessage() . "\n\n" . $e->getTraceAsString();
        }

        return view('deploy.result', [
            'token' => $token,
            'action' => $action,
            'commandName' => $commandName,
            'output' => trim($output) ?: 'Command completed without output text.',
            'success' => $success,
        ]);
    }
}

