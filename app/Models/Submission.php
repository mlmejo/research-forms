<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_filename',
        'path',
        'is_approved',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function researchForm(): BelongsTo
    {
        return $this->belongsTo(ResearchForm::class);
    }
}
