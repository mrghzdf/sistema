<div class="modal_carregando"></div> <!-- loading não remover -->
<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container" style="width: 100%;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= HOME_URI . 'app/home/' ?>" style="padding-top: 4px;"><img
                        src="<?= HOME_URI . 'img/logo.png' ?>"> </a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav" style="font-weight: 600">
                <?php
                $perfilController = new PerfilController();
                $arPais = $perfilController->getMenuByIdPai();

                foreach ($arPais

                as $strKey => $pai) {
                ?>
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><?= $pai['nm_menu'] ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        $arFilhos = $perfilController->getMenuByIdPai($pai['id_menu']);

                        foreach ($arFilhos as $filho) {
                            $boolSubmenu = false;
                            if ($filho['is_submenu'] == 1) {
                                $idMenuSub = $filho['id_menu'];
                                $boolSubmenu = true;
                            } else {
                                $boolSubmenu = false;
                            }

                            $txtMenu = $filho['is_submenu'] ? 'class="dropdown-submenu"' : '';
                            $txtUrlMenu = $filho['is_submenu'] ? 'tabindex="-1" href="#"' : 'href=' . $filho['url_menu'] . '';
                            echo '<li ' . $txtMenu . ' ' . $txtUrlMenu . '>';
                            echo ' <a ' . $txtUrlMenu . '>' . $filho['nm_menu'] . '</a>';

                            // Se submenu adiciona filhos de 1º nível
                            if ($boolSubmenu) {
                                $arFilhosItem = $perfilController->getMenuByIdPai($idMenuSub);
                                // Submenu
                                echo '<ul class="dropdown-menu">';
                                foreach ($arFilhosItem as $subItem) {
                                    echo '<li><a href="' . $subItem['url_menu'] . '">' . $subItem['nm_menu'] . '</a></li>';
                                }
                                echo '</ul>';
                            }
                        }
                        echo '</li>';
                        echo '</ul>';
                        echo '</li>';
                        }
                        ?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="#">Usuário:
                                <strong><?=$_SESSION["nm_login"] . ' - ' . $_SESSION["nm_perfil"] ?></strong>
                            </a>
                        </li>
                        <li><a href="<?= HOME_URI . 'logout.php' ?>"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Sair</a>
                        </li>
                    </ul>
        </div>
    </div>
</nav>