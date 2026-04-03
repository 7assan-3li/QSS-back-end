<?php

namespace App\Services;
use App\Models\PreviousWork;
use App\Models\SystemComplaint;
use Auth;
use Illuminate\Support\Facades\Storage;
class SystemComplaintService
{
    public function create(array $data, $request)
    {
        $user = Auth::user();
        $systemComplaint = SystemComplaint::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'type' => $data['type'],
            'app_source' => $data['app_source'],
            'user_id' => $user->id,
        ]);
        if ($systemComplaint) {
            return $systemComplaint;
        }
        return false;

    }

   
}