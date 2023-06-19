<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use SerializeDateTrait;

class Model extends BaseModel
{
	use HasFactory;
	use SerializeDateTrait;
}
