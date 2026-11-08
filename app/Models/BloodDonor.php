<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class BloodDonor extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_donated_at' => 'date',
        'is_available' => 'boolean',
    ];

    public function upazila(): BelongsTo
    {
        return $this->belongsTo(Upazila::class);
    }

    /**
     * Check if donor is physically eligible/fit to donate blood (>= 90 days or never donated).
     */
    public function isFitToDonate(): bool
    {
        if (!$this->is_available) {
            return false;
        }

        if (!$this->last_donated_at) {
            return true;
        }

        return $this->last_donated_at->diffInDays(now()) >= 90;
    }

    /**
     * Days elapsed since last blood donation.
     */
    public function daysSinceLastDonation(): ?int
    {
        if (!$this->last_donated_at) {
            return null;
        }

        return (int) $this->last_donated_at->diffInDays(now());
    }

    /**
     * Remaining cooldown days until donor becomes fit again.
     */
    public function daysUntilFit(): int
    {
        if (!$this->last_donated_at) {
            return 0;
        }

        $daysSince = (int) $this->last_donated_at->diffInDays(now());
        return max(0, 90 - $daysSince);
    }

    /**
     * Comprehensive fitness status payload for UI rendering.
     */
    public function getFitnessInfoAttribute(): array
    {
        if (!$this->is_available) {
            return [
                'is_fit' => false,
                'status' => 'unavailable',
                'title' => 'সাময়িক স্থগিত',
                'description' => 'বর্তমানে রক্তদানের জন্য অনুপলব্ধ',
                'badge_class' => 'bg-slate-100 text-slate-700 border-slate-200',
                'icon' => 'fa-solid fa-circle-minus',
                'days_remaining' => 0,
                'days_since' => null,
            ];
        }

        if (!$this->last_donated_at) {
            return [
                'is_fit' => true,
                'status' => 'new',
                'title' => 'রক্তদানে প্রস্তুত',
                'description' => 'নতুন রক্তদাতা (পূর্বে রক্ত দেননি)',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'icon' => 'fa-solid fa-circle-check',
                'days_remaining' => 0,
                'days_since' => null,
            ];
        }

        $daysSince = (int) $this->last_donated_at->diffInDays(now());

        if ($daysSince >= 90) {
            return [
                'is_fit' => true,
                'status' => 'fit',
                'title' => 'রক্তদানে প্রস্তুত',
                'description' => 'শেষ রক্তদানের ' . self::toBnNumber($daysSince) . ' দিন অতিক্রান্ত (ফিট)',
                'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'icon' => 'fa-solid fa-circle-check',
                'days_remaining' => 0,
                'days_since' => $daysSince,
            ];
        }

        $daysRemaining = 90 - $daysSince;
        return [
            'is_fit' => false,
            'status' => 'resting',
            'title' => 'বিশ্রামে আছেন',
            'description' => 'আর ' . self::toBnNumber($daysRemaining) . ' দিন পর রক্ত দিতে পারবেন',
            'badge_class' => 'bg-amber-50 text-amber-800 border-amber-200',
            'icon' => 'fa-solid fa-hourglass-half',
            'days_remaining' => $daysRemaining,
            'days_since' => $daysSince,
        ];
    }

    /**
     * Convert English digits to Bengali digits.
     */
    public static function toBnNumber($number): string
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en, $bn, (string)$number);
    }
}
