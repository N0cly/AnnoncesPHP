<?php
namespace gui;
include_once "View.php";

class ViewCreatePost extends View
{
    public function __construct($layout, $presenter)
    {
        parent::__construct($layout);

        $this->title= 'Exemple Annonces Basic PHP: Create Post';

        $this->content = '
        
        <h1>Create Post</h1>
        <form action="/annonces/index.php/createPost" method="post">
        <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
        <label for="body">Body</label>
        <textarea class="form-control" id="body" name="body" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        </form>
        ';
    }

}