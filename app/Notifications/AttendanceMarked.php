<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Attendance;

class AttendanceMarked extends Notification
{
    use Queueable;

    public function __construct(public Attendance $attendance)
    {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'title' => 'Attendance Marked',
            'message' => "Your attendance has been marked as {$this->attendance->status} for {$this->attendance->classSession->subject->name}",
            'type' => 'attendance',
            'data' => [
                'attendance_id' => $this->attendance->id,
                'status' => $this->attendance->status,
                'subject' => $this->attendance->classSession->subject->name,
            ]
        ];
    }
}