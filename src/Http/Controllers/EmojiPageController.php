<?php namespace Jiko\Emoji\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Jiko\Http\Controllers\Controller;
use Jiko\Emoji\Emoji;

class EmojiPageController extends Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  function stopWords($text, $stopwords)
  {

    // Remove line breaks and spaces from stopwords
    $stopwords = array_map(function ($x) {
      return trim(strtolower($x));
    }, $stopwords);

    // Replace all non-word chars with comma
    $pattern = '/[0-9\W]/';
    $text = preg_replace($pattern, ',', $text);

    // Create an array from $text
    $text_array = explode(",", $text);

    // remove whitespace and lowercase words in $text
    $text_array = array_map(function ($x) {
      return trim(strtolower($x));
    }, $text_array);

    foreach ($text_array as $term) {
      if (!in_array($term, $stopwords)) {
        $keywords[] = $term;
      }
    };

    return array_filter($keywords);
  }

  public function horoscope($name = null)
  {
    if ($name == "random") {
      // gemini
      $emojis = Emoji::inRandomOrder()->where('active', 1)->limit(3)->get();
      return response()->view('emoji::horoscope', ['emojis' => $emojis]);
    }

    if($name == "bad") {
      $list = [
        (object) ['name' => 'deep shit', 'emojis' => [821, 86]],
        (object) ['name' => 'bicycle poop', 'emojis' => [1575, 86]],
        (object) ['name'=> 'shitstorm', 'emojis' => [86,1677]],
        (object) ['name' => 'raped', 'emojis' => [1410,61]],
        (object) ['name' => 'dog hit by truck', 'emojis' => [1573, 1291]],
        (object) ['name' => 'stabbed by a clown', 'emojis' => [69, 1481]],
        (object) ['name' => 'screw you', 'emojis' => [1905, 41]],
        (object) ['name' => 'kiss my ass', 'emojis' => [1229, 1301]],
        (object) ['name' => 'bullshit', 'emojis' => [1306, 86]],
        (object) ['name' => 'go to hell', 'emojis' => [76,1698,1953,711]],
        (object) ['name' => 'asshole', 'emojis' => [1404,1456]],
        (object) ['name' => 'cocksucker', 'emojis' => [1333, 1228]],
        (object) ['name' => 'heartbreak', 'emojis' => [1233]],
        (object) ['name' => 'poop', 'emojis' => [86]]
      ];
      $random = $list[rand(0,count($list)-1)];
      $emojis = new Collection();
      foreach($random->emojis as $emoji_id) {
        if($emoji = Emoji::find($emoji_id)) {
          $emojis->add($emoji);
        }
      }
      return response()->view('emoji::horoscope', ['emojis' => $emojis]);
    }

    if ($name == "jiko") {
      $api = json_decode(file_get_contents('http://widgets.fabulously40.com/horoscope.json?sign=pisces'));
      $text = strtolower($api->horoscope->horoscope);
      $stopwords = file(__DIR__ . '/../../stopwords.txt');
      $keywords = $this->stopWords($text, $stopwords);
      $emojis = new Collection();

      foreach ($keywords as $keyword) {
        if ($emoji = Emoji::where('keywords', 'like', '%' . $keyword . '%')->first()) {
          $emojis->add($emoji);
          $text = str_replace($keyword, "<strong>$keyword</strong>", $text);
        }
      }

      return response()->view('emoji::horoscope2', ['emojis' => $emojis, 'horoscope' => $text]);
    }
    if ($name == "delta2") {
      $api = json_decode(file_get_contents('http://widgets.fabulously40.com/horoscope.json?sign=gemini'));
      $text = strtolower($api->horoscope->horoscope);
      $stopwords = file(__DIR__ . '/../../stopwords.txt');
      $keywords = $this->stopWords($text, $stopwords);
      $emojis = new Collection();

      foreach ($keywords as $keyword) {
        if ($emoji = Emoji::where('keywords', 'like', '%' . $keyword . '%')->first()) {
          $emojis->add($emoji);
          $text = str_replace($keyword, "<strong>$keyword</strong>", $text);
        }
      }

      return response()->view('emoji::horoscope2', ['emojis' => $emojis, 'horoscope' => $text]);
    }

    if ($name == "delta") {
      // gemini
      $pregnant = Emoji::find(483);
      $sick = Emoji::find(74);
      $emojis = new Collection([$pregnant, $sick]);
      return response()->view('emoji::horoscope', ['emojis' => $emojis]);
    }

    if ($name == "accident") {
      $emojis = new Collection([Emoji::find(693), Emoji::find(1569)]);
      return response()->view('emoji::horoscope', ['emojis' => $emojis]);
    }

    if ($name == "unicorn") {
      $emojis = new Collection([Emoji::find(1404), Emoji::find(1250), Emoji::find(1304)]);
      return response()->view('emoji::horoscope', ['emojis' => $emojis]);
    }
    $emojis = new Collection([Emoji::find(86)]);
    return response()->view('emoji::horoscope', ['emojis' => $emojis]);
  }

  public function index()
  {
    $emoji = Emoji::where('active', 1)->get();
    return response()->view('emoji::index', ['emojis' => $emoji]);
  }
}