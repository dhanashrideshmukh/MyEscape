
<p>Here is a list of all blogs:</p>

<?php foreach($blogs as $blog) { ?>
  <p>
    <?php echo $blog->title ."<br>";
    
    echo $blog->countryName."<br>";
    echo $blog->continentName."<br>";
    echo $blog->username."<br>";
    echo $blog->categoryName."<br>";
    ?> &nbsp; &nbsp;
<!--    <a href='?controller=product&action=read&blogID= echo $blog->blogID; '> test </a> &nbsp; &nbsp;
    <a href='?controller=product&action=delete&blogID= echo $blog->blogID; '> </a> &nbsp; &nbsp;
    <a href='?controller=product&action=update&content= echo $blog->content; '> </a> &nbsp;
    <a href='?controller=product&action=update&blogID= echo $blog->content; '> </a> &nbsp;
  </p>-->
<?php } ?>
