<?php

namespace Jaktech\Anaphora\Tests\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Jaktech\Anaphora\Traits\Reportable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory, Reportable;
    protected $guarded = [];
}