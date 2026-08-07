<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'language_id',
        'name',
        'email',
        'username'
    ];

    /**
     * Get the agent that owns this translation.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    /**
     * Optional: If your table does not have Laravel's timestamps.
     * Set to false if you don't use created_at / updated_at in agent_translations table.
     */
    public $timestamps = true;
}
