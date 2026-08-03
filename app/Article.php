<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //

    protected $fillable = ['title', 'body', 'tags'];

    protected $mappingProperties = array(
        'title' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
        'body' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
        'tags' => [
          'type' => 'text',
          "analyzer" => "standard",
        ],
      );
}
