<?php

// zapis wizyty do logów
$filename = date('Ymd').'.txt';
$path = 'logs/';//.DIRECTORY_SEPARATOR;
/*if (!file_exists($path.$filename)) {
   $file = fopen($path.$filename, 'w');
   fclose($file);
}*/
$mtime = explode('.', microtime()); // rozbijanie stringów pod kątem innego stringa
$mtime = substr($mtime[1], 2, 4);
$file = fopen($path.$filename, 'a');
fwrite($file, date('H:i:s').'.'.$mtime.' '.$_SERVER['REMOTE_ADDR']."\n");
fclose($file);


setcookie("entry",1, time()+3600*24*30*12*10);


$db = new mysqli('localhost', 'root', '', 'lokalny12',3307);
$db->set_charset('utf8');

// tu aktywne
$query = "SELECT * FROM movie WHERE active=1 ORDER BY date ASC LIMIT 5";
$resource = $db->query($query);
$movies_active = [];
while ($row = $resource->fetch_assoc()) {
    $movies_active[] = $row;
}
$resource->free();

// tu nieaktywne
$query = "SELECT * FROM movie WHERE active=0 ORDER BY id ASC LIMIT 5";
$resource = $db->query($query);
$movies_inactive = [];
while ($row = $resource->fetch_assoc()) {
    $movies_inactive[] = $row;
}
$resource->free();


// tu do $model pobiorę film, którego ID zostało wywołane w adresie
$model = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $query = "SELECT * FROM movie WHERE id=".$_GET['id']." LIMIT 1";
    $resource = $db->query($query);
    $model = $resource->fetch_assoc();
    $resource->free();

    $reviews = [];
    if (!empty($model)) {
        $query = "SELECT * FROM movie_review WHERE movie_id=" . $model['id'] . ";";
        $resource = $db->query($query);
        while ($row = $resource->fetch_assoc()) {
            $reviews[] = $row;
        }
        $model['reviews'] = $reviews;
        $resource->free();    
    }

}




$db->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= !empty($model) ? $model['title'].' - ' : '' ?>My favourite movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.collapsible {
  background-color: #000000;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #191919;
}

.collapsible:after {
  content: '\002B';
  color: white;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}

.content {
  padding: 0 18px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
  background-color: #f1f1f1;
}
</style>
</head>
<body>


<header>
    <div class="collapse bg-dark" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">About</h4>
                    <p class="text-muted">Add some information about the album below, the author, or any other background context. Make it a few sentences long so folks can pick up some informative tidbits. Then, link them off to some social networking sites or contact information.</p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <h4 class="text-white">Contact</h4>
                    <ul class="list-unstyled">
                        <li><a href="https://www.facebook.com/edmund.kawalec" class="text-white">Like on Facebook</a></li>
                        <li><a href="mailto:e.kawalec@s4studio.pl" class="text-white">Email me</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="<?= basename(__FILE__) ?>" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <strong>Album</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>

<main id="main" class="bg-light">

    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">My Favourite Movies Album</h1>
            <p class="lead text-muted">All made for your purpose :)</p>
            <p class="lead text-muted">
                <?php
                   if (isset($_COOKIE['entry'])) {
       echo 'Welcome Back';
   } else {
       echo 'Welcome';
   }




                ?>
        </p>
        </div>
    </section>



    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php if (!empty($model)): ?>
                    <div class="row">
                        <?php if (!empty($model['poster'])): ?>
                            <div class="col-md-3">
                                <a data-fancybox="gallery" href="<?= $model['poster'] ?>" title="<?= $model['title'] ?>">
                                    <img src="<?= $model['poster'] ?>" alt="<?= $model['title'] ?>" class="img-thumbnail" />
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-<?= empty($model['poster']) ? '12' : '9' ?>">
                            <h1><?= $model['title'] ?> (<?= $model['date'] ?>)</h1>
                            <p>
                                <?= !empty($model['description']) ? $model['description'] : 'description text coming soon' ?>
                            </p>
                        </div>
                    </div>
                    <p>
                        <?= !empty($model['tech_info']) ? $model['tech_info'] : 'tech_info coming soon' ?>
                    </p>
                    <div class="row">
                        <?php foreach ($model['reviews'] as $review) : ?>
                            <button class="collapsible">
                                <h5><?= $review['title'] ?></h5>
                                <div class="text-right">Author: <strong><?= $review['review_author'] ?></strong><small> (source: <?= $review['review_source'] ?>)</small></div>
                            </button>
                            <div class="content">                                
                                <p><?= $review['content'] ?></p>
                            </div>
                        <?php endforeach; ?>  
                    </div> 
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>Comments</h2>
                                    <form action="comment.php" method="post">
                                    <input type="hidden" name="movie_id" value="<?= $review['id'] ?>" required>
                                    <input type="username" placeholder="Username" name="author" required>
                                    <textarea type="content" rows="4" cols="103" placeholder="Add comment... (255 characters)" name="content" required></textarea>
                                    <div class="text-right"><button type="submit" class="btn btn-dark">Add <i class="fas fa-arrow-right"></i></button></div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            $db = new mysqli('localhost', 'root', '', 'lokalny12',3307);
                            $query = "SELECT * FROM comment WHERE movie_id = {$review['id']} ORDER BY id DESC;";
                            $resource = $db->query($query);
                            $comments = [];
                            while ($row = $resource->fetch_assoc()) {
                            $comments[] = $row;
                            }
                            $resource->free();
                            ?>
                                <div class="clearfix"></div>
                                <?php foreach ($comments as $comment): ?>
                                    <div>
                                        <div><strong><?= $comment['author'] ?></strong> <small><small><?= date('Y-m-d H:i:s',$comment['created_at']) ?></small></small></div>
                                        <p><?= $comment['content'] ?></p>
                                    </div>
                                <?php endforeach; ?>
                        </div>
                    </div>



                                
                <?php else: ?>
                    <p class="lead text-muted">Welcome, choose film position from right sidebar :)</p>
                    <p><img src="https://picsum.photos/600/400" alt=""></p>
                    <h1>Register now!</h1>
            <form>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">User</label>
      <input type="email" class="form-control" id="inputEmail4" placeholder="Username">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Email</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="Input Email">
  </div>
  <button type="submit" class="btn btn-dark">Sign in</button>
</form>
<button id="getLog">Show log</button>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <h3>Already seen</h3>
                <ul>
                    <?php foreach ($movies_active as $movie): ?>
                        <li>
                            <a href="<?= basename(__FILE__) ?>?id=<?= $movie['id'] ?>">
                                <?= $movie['title'] ?> (<?= $movie['date'] ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <h3>Wait in queue</h3>
                <ul>
                    <?php foreach ($movies_inactive as $movie): ?>
                        <li>
                            <a href="<?= basename(__FILE__) ?>?id=<?= $movie['id'] ?>">
                                <?= $movie['title'] ?> (<?= $movie['date'] ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </div>


</main>


<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Back to top</a>
        </p>
        <p>Movies album made in &copy; Bootstrap, using PHP & MySQL, created for <strong>LokalnyProgramista.pl</strong>!</p>
    </div>
</footer>


<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script>
    Cookies.set('entry.javascript','ok');
    //Console.log(Cookies.get('entry.php'));
    $('#clearCookies').click(function() {
   Cookies.remove('entry_php', { path: '' });
   alert('cookies remove');
});

    $('#getLog').click(function() {
   $.ajax({
       method: 'get',
       url: '<?= $path.$filename ?>',
       success: function(response) {
           alert(response);
       }
   })
});

</script>
</body>
</html>