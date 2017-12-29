<aside class="col-sm-3 col-lg-2">
    <div class="page-header text-center">
        <h1><?php echo $page_title ?></h1>
    </div>
    <div class="main-menu">
        <header class="header-sidebar text-center">
            <div class="picture">
                <a href="<?php echo base_url() ?>chef/perfil">
                    <img src="<?php echo (($this->session->userdata('user')->picture == 'user_default.png' and $this->session->userdata('user')->facebook_id) ? 'https://graph.facebook.com/'.$this->session->userdata('user')->facebook_id.'/picture?type=square' : base_url().'uploads/'.$user['picture'])?>" alt="" class="img-responsive img-rounded center-block" />
                </a>
            </div>
            <p>Chef <?php echo $this->session->userdata('user')->name ?> <?php echo $this->session->userdata('user')->lastname ?></p>
        </header>
        <nav>
            <ul class="nav nav-pills nav-stacked">
                <li <?php if ($this->uri->segment(2) == "perfil") echo "class='active'"; ?>><a href="<?php echo site_url('chef/perfil') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/perfil.png") ?>" /> Perfil</a></li>
                <li <?php if ($this->uri->segment(2) == "amigos") echo "class='active'"; ?>><a href="<?php echo site_url('chef/amigos') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/amigos.png") ?>" /> Amigos (sua rede) <span class="badge bg-danger solicitacoes_badge hide" id="solicitacoes_badge">0</span></a></li>
                <li <?php if ($this->uri->segment(3) == "novo") echo "class='active'"; ?>><a href="<?php echo site_url('chef/evento/novo') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/novo-evento.png") ?>" /> Criar um novo Encontro Gastronômico</a></li>
                <li <?php if ($this->uri->segment(2) == "evento" && !$this->uri->segment(3)) echo "class='active'"; ?>><a href="<?php echo site_url('chef/evento') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/eventos.png") ?>" /> Meus encontros Gastronômicos</a></li>
                <li <?php if ($this->uri->segment(2) == "clube") echo "class='active'"; ?>><a href="<?php echo site_url('chef/clube') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/club-vantagens.png") ?>" /> Clube de Vantagens</a></li>
                <li <?php if ($this->uri->segment(2) == "faq") echo "class='active'"; ?>><a href="<?php echo site_url('chef/faq') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/duvidas.png") ?>" /> Perguntas Frequentes</a></li>
                <li <?php if ($this->uri->segment(2) == "senha") echo "class='active'"; ?>><a href="<?php echo site_url('chef/senha') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/senha.png") ?>" /> Alterar Senha</a></li>
                <li <?php if ($this->uri->segment(2) == "logout") echo "class='active'"; ?>><a href="<?php echo site_url('logout') ?>"><img class="li-icon" src="<?php echo site_url("assets/img/chef/logout.png") ?>" /> Sair</a></li>
            </ul>
        </nav>
    </div>
</aside>
