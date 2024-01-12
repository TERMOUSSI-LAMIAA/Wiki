<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wiki-Home</title>

    <!-- Custom fonts for this template-->
    <link href="view\assets\vendor\fontawesome-free\css\all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="view\assets\css\sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">



        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" id="searchInput"
                                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="searchButton" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle " href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Register -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=register">
                                <i class="fas fa-user-plus fa-fw"></i>&nbsp;
                                S'inscrire
                            </a>
                        </li>

                        <!-- Nav Item - Login -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=loginForm">
                                <i class="fas fa-key fa-fw"></i>&nbsp;
                                Login
                            </a>
                        </li>


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - Home -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?action=home">
                                <i class="fas fa-home fa-fw"></i>&nbsp;
                                Accueil
                            </a>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="text-center mb-4">
                        <img src="asset\images\redaction-creative-texte-commercial-seo-edition.jpg" alt="image"
                            height="500px" class="img-fluid">
                    </div>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- First Column -->
                        <div class="col-lg-4">

                            <!-- Custom Text Color Utilities -->
                            <div class="card shadow mb-4" id="wiki-search-results">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tous les wikis</h6>
                                </div>
                                <?php foreach ($wikis as $b): ?>
                                    <div class="card-body">
                                        <p> Categorie:
                                            <strong>
                                                <?= $b->getFk_cat(); ?>
                                            </strong>
                                        </p>
                                        <h6> Titre:
                                            <a href="index.php?action=detailWiki&id_w=<?= $b->getId_w(); ?>"
                                                class="card-title-link">
                                                <strong>
                                                    <q>
                                                        <?= $b->getTitre(); ?>
                                                    </q>
                                                </strong></a>
                                        </h6>
                                        <img src="data:image/jpeg;base64,<?= base64_encode($b->getImg()); ?>" alt="no image"
                                            class="img-fluid mb-3" style="max-height: 100px;">

                                        <p>
                                            <?= substr($b->getContenu(), 0, 120) . '...'; ?>
                                        </p>
                                        <p>
                                            <i>
                                                <?= $b->getWiki_date(); ?>
                                            </i>
                                        </p>
                                        <p> Auteur email:
                                            <strong>
                                                <?= $b->getFk_aut_email(); ?>
                                            </strong>
                                        </p>
                                        <p>Tags:
                                            <?php
                                            $tags = $b->getTags();
                                            if ($tags && count($tags)) {
                                                foreach ($tags as $tag) {
                                                    echo $tag->getNom_tag();
                                                    echo ' ';
                                                }
                                            } else {
                                                echo 'Aucun tag';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>

                            <!-- Custom Font Size Utilities -->


                        </div>

                        <!-- Second Column -->
                        <div class="col-lg-4">

                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Les wikis récents</h6>
                                </div>
                                <?php foreach ($recwikis as $b): ?>
                                    <div class="card-body">
                                        <p> Categorie:
                                            <strong>
                                                <?= $b->getFk_cat(); ?>
                                            </strong>
                                        </p>
                                        <h6> Titre:
                                            <a href="index.php?action=detailWiki&id_w=<?= $b->getId_w(); ?>"
                                                class="card-title-link">
                                                <strong>
                                                    <q>
                                                        <?= $b->getTitre(); ?>
                                                    </q>
                                                </strong></a>
                                        </h6>
                                        <img src="data:image/jpeg;base64,<?= base64_encode($b->getImg()); ?>" alt="image"
                                            class="img-fluid mb-3" style="max-height: 100px;">

                                        <p>
                                            <?= substr($b->getContenu(), 0, 120) . '...'; ?>
                                        </p>
                                        <p>
                                            <i>
                                                <?= $b->getWiki_date(); ?>
                                            </i>
                                        </p>
                                        <p> Auteur email:
                                            <strong>
                                                <?= $b->getFk_aut_email(); ?>
                                            </strong>
                                        </p>
                                        <p>Tags:
                                            <?php
                                            $tags = $b->getTags();
                                            if ($tags !== null) {
                                                foreach ($tags as $tag) {
                                                    echo $tag->getNom_tag();
                                                    echo ' ';
                                                }
                                            } else {
                                                echo 'Aucun tag';
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <!-- Third Column -->
                        <div class="col-lg-4">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Les catégories récents</h6>
                                </div>
                                <?php foreach ($reccatgs as $b): ?>
                                    <div class="card-body">
                                        <p> Categorie:
                                            <strong>
                                                <?= $b->getNom_cat(); ?>
                                            </strong>
                                        </p>
                                        <p>
                                            <i>
                                                <?= $b->getCat_date(); ?>
                                            </i>
                                        </p>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="view\assets\vendor\jquery\jquery.min.js"></script>
    <script src="view\assets\vendor\bootstrap\js\bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="view\assets\vendor\jquery-easing\jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="view\assets\js\sb-admin-2.min.js"></script>

    <script>

        $(document).ready(function () {
            $("#searchButton").click(function () {
                var inputValue = $("#searchInput").val();
                $.ajax({
                    url: 'index.php',
                    method: 'GET',
                    data: {
                        action: 'search',
                        searchVal: inputValue
                    },
                    dataType: "JSON",
                    success: function (response) {
                        let html = `<div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Résultat de recherche</h6>
                                </div>`;
                        if (response.data.length > 0) {
                            response.data.forEach(element => {
                                // console.log(element);
                                console.log('Tags:', element.tags);
                                html += `
                                    <div class="card-body">
                                        <p> Categorie:
                                            <strong>
                                            ${element.fk_cat}
                                            </strong>
                                        </p>
                                        <h6> Titre:
                                            <a href="index.php?action=detailWiki&id_w= ${element.id}"
                                                class="card-title-link">
                                                <strong>
                                                    <q>
                                                    ${element.titre}
                                                    </q>
                                                </strong></a>
                                        </h6>
                                        <img src="data:image/jpeg;base64, ${element.base64Image}" alt="image"
                                            class="img-fluid mb-3" style="max-height: 100px;">

                                        <p>
                                        ${element.contenu}
                                        </p>
                                        <p>
                                            <i>
                                            ${element.wiki_date}
                                            </i>
                                        </p>
                                        <p> Auteur email:
                                            <strong>
                                            ${element.fk_aut_email}
                                            </strong>
                                        </p>
                                        <p>Tags:
                                       ${element.tags.length > 0 ? element.tags.join(', ') : 'Aucun tag'}
                                        </p>
                                    </div>
                                    <hr>
                            </div>
                              `;
                            });

                        } else {
                            html = '<div class="alert alert-warning">No data found.</div>';
                        }
                        $("#wiki-search-results").html(html);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        console.log('Response Text:', jqXHR.responseText);
                    }
                });
            });
        });


    </script>
</body>

</html>