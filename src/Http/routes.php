<?php
Route::group(['namespace' => 'Jiko\Emoji\Http\Controllers'], function () {
  Route::get('emoji', 'EmojiPageController@index');
  Route::get('emoji/horoscope', 'EmojiPageController@horoscope');
  Route::get('emoji/horoscope/{name}', 'EmojiPageController@horoscope');
});