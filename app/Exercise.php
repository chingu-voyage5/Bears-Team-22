<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
  public $fillable = [
      'title',
      'description'
  ];}
