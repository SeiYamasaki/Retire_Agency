<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'name_furigana',
        'gender',
        'birth_date',
        'age',
        'line_name',
        'postal_code',
        'prefecture',
        'address',
        'residence',
        'contact_email',
        'contact_phone',
        'company_name',
        'work_postal_code',
        'work_prefecture',
        'work_address',
        'work_email',
        'work_contact_phone',
        'work_superior_phone',
        'employment_type',
        'job_type',
        'years_of_service',
        'current_status',
        'desired_resignation_date',
        'final_work_date',
        'paid_leave_preference',
        'resignation_contact',
        'bank_name',
        'account_type',
        'account_number',
        'account_holder',
        'employment_contract',
        'id_proof',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'account_number', // セキュリティ対策として非表示
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'desired_resignation_date' => 'date',
            'final_work_date' => 'date',
            'age' => 'integer',
        ];
    }
}
