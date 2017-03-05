<?php namespace Jiko\Emoji;

use Illuminate\Database\Eloquent\Model;

class Emoji extends Model
{

  protected $table = 'emoji';

  protected $fillable = ['name', 'keywords'];

  public function getImagesAttribute($value)
  {
    $codes = [];
    $sources = [];

    // remove variation selector
    $this->code = str_replace(' U+FE0F', '', $this->code);

    // handle joined emoji
    if(strstr($this->code, 'U+200D')) {
      // explode on U+200D
      $codes = array_merge(explode(' U+200D ', $this->code), $codes);
      foreach($codes as $i => $code) {
        $codes[$i] = str_replace(' ', '-', strtolower(str_replace('U+', '', $code)));
      }
    }
    else {
      $codes[] = str_replace(' ', '-', strtolower(str_replace('U+', '', $this->code)));
    }
    foreach ($codes as $img_name) {
      $sources[] = cdn_img_path() . "/emoji/$img_name.svg";
    }
    return $sources;
  }
  }