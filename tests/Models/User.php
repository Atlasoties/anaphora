<?php

namespace Jaktech\Anaphora\Tests\Models;

use Jaktech\Anaphora\Traits\Reportable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jaktech\Anaphora\Exceptions\ArgumentExceptions;

class User extends Model
{
    use HasFactory, Reportable;
    protected $guarded = [];
}