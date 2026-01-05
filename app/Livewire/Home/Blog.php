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
        // Initialize defaults
        $this->show = false;
        $this->post = null;
        
        // Check for featured post first
        $featured = BlogPost::where("permenantly_featured", true)
            ->orderBy("created_at", "desc")
            ->first();
            
        if ($featured) {
            $this->show = true;
            $this->featured = true;
            $this->post = $featured;
            return;
        }
        
        // No featured post, check for recent posts
        $recentPost = BlogPost::orderBy("created_at", "desc")->first();
        
        if ($recentPost) {
            $this->post = $recentPost;
            
            // Get the current date and time
            $now = Carbon::now();
            
            // Calculate the difference in days
            $difference = $now->diffInDays($this->post->created_at);
            
            // Check if the post is less than two weeks old
            if ($difference < 14) {
                $this->show = true;
            }
        }
        
        // If no posts exist or post is too old, $this->show remains false
    }

    public function render()
    {
        return view("livewire.home.blog");
    }
}
