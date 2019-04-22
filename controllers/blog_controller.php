<?php

class BlogController {

    public function readAll() {
        $blogs = Blog::all();
        require_once('views/blogs/readAll.php');
    }

    public function read() {
        // we expect a url of form ?controller=posts&action=show&id=x
        // without an id we just redirect to the error page as we need the post id to find it in the database
        if (!isset($_GET['blogID']))
            return call('pages', 'error');

        try {
            // we use the given id to get the correct post
            $blog = Blog::find($_GET['blogID']);
            require_once('views/blogs/read.php');
            
            
            
        } catch (Exception $ex) {
            return call('pages', 'error');
        }
    }
    
    public function addComment () {
          if (isset($_GET['blogID'])) {
           

        try {
            $blogid = $_GET['blogID'];
            // we use the given id to get the correct post
            $blog = Blog::addComment($blogid);
            require_once('views/blogs/read.php');
            
            
            
        } catch (Exception $ex) {
            return call('pages', 'error');
        }
        
        
    }
    }

    public function create() {
        // we expect a url of form ?controller=products&action=create
        // if it's a GET request display a blank form for creating a new product
        // else it's a POST so add to the database and redirect to readAll action
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once('views/blogs/create.php');
        } else {
            Blog::add();

            #Can't get this to work
            #$blogs = User::readMine($_GET['username']);
            #require_once('views/users/readMine.php'); 

            $blogs = Blog::all();
            require_once('views/blogs/readAll.php');
        }
    }

    public function update() {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!isset($_GET['blogID']))
                return call('pages', 'error');#requires better exception handling
            // we use the given id to get the correct blog for updating
            $blog = Blog::find($_GET['blogID']);

            require_once('views/blogs/update.php');
        }
        else {
            $id = $_GET['blogID'];
            Blog::modify($id);

            $blogs = Blog::all();
            require_once('views/blogs/readAll.php');
        }
    }

    public function delete() {
        Blog::delete($_GET['blogID']);

        $blogs = Blog::all();
        require_once('views/blogs/readAll.php');
    }

    public function search() {

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            require_once('views/blogs/search.php');
        } else {
            if (!empty($_POST['query'])) {
                Try {
                    $blogs = Blog::search();
                    require_once('views/blogs/search.php');
                    
                } catch (Exception $ex) {
                    return call('pages', 'error');
                }
            } else {
                echo '<br><br>please type something!<br><br>';
            }
        }
    }
}

?>
