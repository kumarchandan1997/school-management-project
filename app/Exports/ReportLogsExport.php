<?php

namespace App\Exports;

use App\Models\ReportLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;

class ReportLogsExport implements FromQuery, WithHeadings, WithMapping
{
    
    protected $search;

    public function __construct($search)
    {
        $this->search = $search;
    }
    
    public function query()
    {
        return ReportLog::query()
            ->leftJoin('videos', 'reportlogs.video_id', '=', 'videos.id')
            ->leftJoin('subjects', 'videos.subject_code', '=', 'subjects.subject_code')
            ->leftJoin('teachers', 'videos.teacher_id', '=', 'teachers.id')
            ->leftJoin('classrooms', 'videos.classroom_id', '=', 'classrooms.id')
            ->select(
                'reportlogs.id',
                'videos.course_title',
                DB::raw('CONCAT(teachers.first_name, " ", teachers.surname) as fullname'),
                'classrooms.name as classroom_name',
                'subjects.name as subject_name',
                'videos.video',
                'reportlogs.open_time',
                'reportlogs.close_time',
                'reportlogs.interval'
            )
            ->when($this->search, function ($query, $search) {
                $query->where('videos.course_title', 'like', "%{$search}%")
                    ->orWhere('subjects.name', 'like', "%{$search}%")
                    ->orWhere('reportlogs.open_time', 'like', "%{$search}%")
                    ->orWhere('classrooms.name', 'like', "%{$search}%")
                    ->orWhere(DB::raw('CONCAT(teachers.first_name, " ", teachers.surname)'), 'like', "%{$search}%");
            });
    }

    public function headings(): array
    {
        return [
            'Id',
            'Content Name',
            'Teacher',
            'Classroom',
            'Subject',
            'Content',
            'Open Time',
            'Close Time',
            'Total Time',
        ];
    }

    public function map($log): array
    {
        $openTime = new \DateTime($log->open_time);
        $closeTime = new \DateTime($log->close_time);
        $interval = $openTime->diff($closeTime);
        $formattedInterval = $interval->format('%h hours %i minutes');

        return [
            $log->id,
            $log->course_title,
            $log->fullname,
            $log->classroom_name,
            $log->subject_name,
            $log->video,
            $log->open_time,
            $log->close_time,
            $formattedInterval,
        ];
    }
}