<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PlatformUpdateNotification;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

abstract class Controller
{
    protected function workspaceView(Request $request, string $view, array $data = []): View
    {
        $prefix = match ($request->user()->role) {
            'mahasiswa' => 'student',
            'staf' => 'university',
            'perusahaan' => 'company',
            'company_supervisor' => 'company_supervisor',
            'university_supervisor', 'dosen' => 'university_supervisor',
            default => 'student',
        };

        return view($prefix.'.'.$view, $data);
    }

    /**
     * @param  iterable<int, User|null>|Collection<int, User|null>|EloquentCollection<int, User|null>  $users
     */
    protected function notifyUsers(iterable $users, string $title, string $body, ?string $actionUrl = null, string $actionText = 'Buka CareerBridge'): void
    {
        $recipients = collect($users)
            ->filter(fn (?User $user) => $user && filled($user->email))
            ->unique('id')
            ->values();

        if ($recipients->isEmpty()) {
            return;
        }

        Notification::send($recipients, new PlatformUpdateNotification($title, $body, $actionUrl, $actionText));
    }
}
