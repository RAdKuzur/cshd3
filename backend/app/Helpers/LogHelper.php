<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\DB;

class LogHelper
{
    public static function insert($table, array $bindings) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => $table,
            'type' => Log::INSERT,
            'bindings' => json_encode($bindings),
            'extra_bindings' => null,
            'time' => now()
        ]);
    }
    public static function update($table, array $bindings, array $extraBindings) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => $table,
            'type' => Log::UPDATE,
            'bindings' => json_encode($bindings),
            'extra_bindings' => json_encode($extraBindings),
            'time' => now()
        ]);
    }
    public static function delete($table, array $extraBindings) {
        DB::table('logs')->insert([
            'user_id' => Auth::user()->id,
            'table' => $table,
            'type' => Log::DELETE,
            'bindings' => null,
            'extra_bindings' => json_encode($extraBindings),
            'time' => now()
        ]);
    }

    public static function error(string $message, string $trace)
    {
        DB::table('error_logs')->insert([
            'message' => $message,
            'trace' => $trace,
            'time' => now()
        ]);
    }
}
