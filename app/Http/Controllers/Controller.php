<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class Controller
{
    protected function workspaceView(Request $request, string $view, array $data = []): View
    {
        $prefix = match ($request->user()->role) {
            'mahasiswa' => 'student',
            'staf' => 'university',
            'perusahaan' => 'company',
            'dosen' => 'professor',
            default => 'student',
        };

        return view($prefix.'.'.$view, $data);
    }
}
