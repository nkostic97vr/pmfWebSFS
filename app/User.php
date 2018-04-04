<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() {
        return $this->hasMany("App\Post");
    }

    public function reports() {
        return $this->belongsToMany("App\Post", "user_reports");
    }

    public function ratings() {
        return $this->belongsToMany("App\Post", "user_ratings");
    }

    public function readTopics() {
        return $this->belongsToMany("App\Topic", "read_topics");
    }

    public function pollAnswers() {
        return $this->belongsToMany("App\PollAnswer", "user_answers");
    }

    public function watchedSections() {
        return $this->belongsToMany("App\Section", "section_watchers");
    }

    public function watchedForums() {
        return $this->belongsToMany("App\Forum", "forum_watchers");
    }

    public function watchedTopics() {
        return $this->belongsToMany("App\Topic", "topic_watchers");
    }
}