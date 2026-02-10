<?php

namespace App\Services;
use App\constant\VerificationRequestStatus;
use App\Models\VerificationRequest;
use Auth;
class VerificationRequestService
{
   
    public function create(array $data)
    {
       $user = Auth::user();
       $verificationRequest = VerificationRequest::create([
           "user_id"=>$user->id,
           "content"=>$data["content"],
           "status"=>VerificationRequestStatus::PENDING
       ]);
       return $verificationRequest;
    }

}