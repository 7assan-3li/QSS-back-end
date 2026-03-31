<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleServiceRequest;
use App\Http\Requests\UpdateScheduleServiceRequest;
use App\Models\ScheduleService;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ScheduleServiceController extends Controller
{
    public function index($serviceId)
    {
        $schedules = ScheduleService::where('service_id', $serviceId)
            ->with('days')
            ->get();
            
        return response()->json($schedules);
    }

    public function store(StoreScheduleServiceRequest $request)
    {
        $data = $request->validated();
        
        $schedule = DB::transaction(function () use ($data) {
            $schedule = ScheduleService::create([
                'service_id' => $data['service_id'],
                'label'      => $data['label'] ?? null,
                'start_time' => $data['start_time'],
                'end_time'   => $data['end_time'],
            ]);

            foreach ($data['days'] as $day) {
                $schedule->days()->create(['day' => $day]);
            }

            return $schedule->load('days');
        });

        return response()->json($schedule, 201);
    }

    public function update(UpdateScheduleServiceRequest $request, $id)
    {
        $data = $request->validated();
        $schedule = ScheduleService::findOrFail($id);

        $schedule = DB::transaction(function () use ($data, $schedule) {
            $schedule->update([
                'label'      => $data['label'] ?? $schedule->label,
                'start_time' => $data['start_time'],
                'end_time'   => $data['end_time'],
                'is_active'  => $data['is_active'] ?? $schedule->is_active,
            ]);

            // ريفرش للأيام (مسح القديم وإضافة الجديد)
            $schedule->days()->delete();
            foreach ($data['days'] as $day) {
                $schedule->days()->create(['day' => $day]);
            }

            return $schedule->load('days');
        });

        return response()->json($schedule);
    }

    public function destroy($id)
    {
        $schedule = ScheduleService::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'تم حذف الجدول الزمني بنجاح']);
    }
}
