
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Escape</title>
    </head>
    <body>
        <?php
    require_once('connection.php');
        
    if (isset($_GET['controller']) && isset($_GET['action'])) {
        $controller = $_GET['controller'];
        $action     = $_GET['action'];
  } else {
        $controller = 'pages';
        $action     = 'home';
  }
    
  #require_once('views/layout.php')
  
  if (isset($_GET['action']) && ($_GET['action'] != ('likeBlog' || 'dislikeBlog'))) {
        require_once('views/layout.php');
  }
  else {require_once('routes.php');      
  }
  
  
//   if (isset($_GET['action']) && ($_GET['action'] = ('likeBlog' || 'dislikeBlog'))) {
//        require_once('routes.php');
//  }
//  elseif($_GET['controller']='pages'){
//      require_once('views/layout.php');   
//  }
//    else {
//        require_once('views/layout.php');      
//  }
 
  ;
    
        ?>
    </body>
</html>
