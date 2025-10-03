<!-- Rodapé -->
<footer class="bg-light text-center text-muted py-3 border-top">
    <div class="container">
        <small>© <?= date('Y') ?> - SiMoRI | Desenvolvido em CodeIgniter 4 + Bootstrap 5</small>
    </div>
</footer>

<style>

    /* Camadas que se movimentam */
    .layer {
        position: absolute;
        bottom: 0;
        width: 200%;
        background-repeat: repeat-x;
    }

    .build01 {
        background: url("<?= base_url('/assets/background/build-01.png'); ?>") repeat-x;
        animation: moveBuild01 60s linear infinite;
        z-index: 1;
        height: 180px;
        bottom: -110px;
    }

    /* Segunda camada */
    .build02 {
        background: url("<?= base_url('/assets/background/build-02.png'); ?>") repeat-x;
        animation: moveBuild01 30s linear infinite;
        z-index: 2;
        height: 80px;
        bottom: -25px;
    }

    /* Animações */
    @keyframes moveBuild01 {
        from {
            transform: translateX(0%);
        }

        to {
            transform: translateX(-50%);
        }
    }

    /* Logo centralizada */
    .logo {
        position: relative;
        z-index: 10;
        text-align: center;
    }
</style>

<div class="container shunshine">
    <div class="row">
        <!-- LOGO -->
        <div class="logo col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
            <img src="<?= base_url('/assets/logo/logo_full_white.png'); ?>"
                class="img-fluid mt-5"
                alt="Logo">
        </div>

        <!-- Camadas com paralaxe -->
        <div class="layer build01"></div>
        <div class="layer build02"></div>
    </div>
</div>