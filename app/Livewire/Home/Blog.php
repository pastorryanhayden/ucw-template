<?php

namespace App\Livewire\Home;

use App\Models\BlogPost;
use Carbon\Carbon;
use Livewire\Component;

// This component is for the home page and should only show a blog post if it is less than two weeks old.

class Blog extends Component
{
    public $show = false;

    public $post;

    public $featured = false;

    public function mount()
    {
        $featured = BlogPost::where("permenantly_featured", true)
            ->orderBy("created_at", "desc")
            ->first();
        if ($featured) {
            $this->show = true;
            $this->featured = true;
            $this->post = $featured;
        } else {
            if (BlogPost::all()->count() > 0) {
                $this->post = BlogPost::orderBy("created_at", "desc")->first();
            }
            // Check if the most recent post exists
            if ($this->post) {
                // Get the current date and time
                $now = Carbon::now();

                // Calculate the difference in days
                $difference = $now->diffInDays($this->post->created_at);

                // Check if the post is less than two weeks old
                if ($difference < 14) {
                    // The post is less than two weeks old
                    $this->show = true;
                } else {
                    // The post is older than two weeks
                    $this->show = false;
                }
            } else {
                // No posts found
                $this->show = false;
            }
        }
    }

    public function render()
    {
        return view("livewire.home.blog");
    }
}
