<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upazila extends Model
{
    protected $guarded = [];

    public function emergencyServices(): HasMany
    {
        return $this->hasMany(EmergencyService::class);
    }

    public function bloodDonors(): HasMany
    {
        return $this->hasMany(BloodDonor::class);
    }

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function hospitals(): HasMany
    {
        return $this->hasMany(Hospital::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }

    public function touristPlaces(): HasMany
    {
        return $this->hasMany(TouristPlace::class);
    }
}

