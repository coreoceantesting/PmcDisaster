<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'complaint_unique_id',
        'complaint_type',
        'complaint_sub_type',
        'manual_complaint_no',
        'caller_name',
        'caller_mobile_no',
        'caller_address',
        'complaint_details',
        'location',
        'departments',
        'uploaded_doc',
        'approval_status',
        'approval_remark',
        'approval_by',
        'approval_at',
        'closing_status',
        'closing_remark',
        'closing_by',
        'closing_at'
    ];

    public static function booted()
    {
        static::created(function (self $user)
        {
            if(Auth::check())
            {
                self::where('id', $user->id)->update([
                    'created_by'=> Auth::user()->id,
                ]);
            }
        });
        static::updated(function (self $user)
        {
            if(Auth::check())
            {
                self::where('id', $user->id)->update([
                    'updated_by'=> Auth::user()->id,
                ]);
            }
        });
        static::deleting(function (self $user)
        {
            if(Auth::check())
            {
                self::where('id', $user->id)->update([
                    'deleted_by'=> Auth::user()->id,
                ]);
            }
        });
    }
}
