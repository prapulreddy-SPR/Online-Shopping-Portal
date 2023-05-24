<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ONLINE SHOPPING</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <?php if ($_SESSION["logged_in"]) : ?>
            <li class="nav-item">
          <a class="nav-link" href="#" role="button" aria-expanded="true">
            Administrator
          </a>
        </li>
          <?php else : ?>
            <a class="nav-link active" aria-current="page" href="/index.php">Back to Portal</a>
          <?php endif ?>
        </li>
      </ul>
    </div>
  </div>
</nav>