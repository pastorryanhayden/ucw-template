<?php

namespace App\Livewire\Blog;

use App\Models\BlogPost;
use App\Models\Speaker;
use Livewire\Component;

class Morefrom extends Component
{
    public $author;

    public $posts;

    public $show;

    public function mount($author, $post)
    {
        $this->author = Speaker::find($author);
        $this->posts = BlogPost::where('speaker_id', $author)->where('published', true)->where('id', '!=', $post)->orderBy('created_at', 'desc')->take(3)->get();
        $this->show = $this->posts->count() > 1 ? true : false;
    }

    public function render()
    {
        return view('livewire.blog.morefrom');
    }
}
