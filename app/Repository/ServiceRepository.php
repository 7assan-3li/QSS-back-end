<?php

namespace App\Repository;
use App\Models\Service;
use Auth;
class ServiceRepository
{

    public function create(array $data)
    {
        $service = Service::create($data);
        return $service;
    }

    public function update(array $data)
    {
        $service = Service::update($data);
        return $service;
    }

    public function delete(array $data)
    {
        $service = Service::delete($data);
        return $service;
    }

    public function find(array $data)
    {
        $service = Service::find($data);
        return $service;
    }

    public function findBy(array $data)
    {
        $service = Service::findBy($data);
        return $service;
    }



}