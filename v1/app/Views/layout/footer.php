<div style="height: 80px;"></div>
<div class="minha-div">
    <!-- Camada do fundo animado -->
    <div class="layer build01"></div>
    <div class="layer build02"></div>

    <!-- Camada do texto acima -->
    <div class="footer-text">
        <span class="text-white">
            &copy; 2025-<?= date('Y'); ?> - Powered by
            <a href="https://brapci.inf.br/projects" class="link text-white text-decoration-none">
                brapci.inf.br
            </a>
        </span>
    </div>
</div>

<style>
    .minha-div {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80px;
        overflow: hidden;
        z-index: 1000;
    }

    .build01,
    .build02 {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background-repeat: repeat-x;
    }

    .build01 {
        background-image: url("<?= base_url('/assets/background/build-01.png'); ?>");
        height: 75px;
        animation: moveBuild01 60s linear infinite;
        z-index: 1;
    }

    .build02 {
        background-image: url("<?= base_url('/assets/background/build-02.png'); ?>");
        height: 65px;
        animation: moveBuild02 190s linear infinite;
        z-index: 2;
    }

    /* Texto sobre as camadas */
    .footer-text {
        position: absolute;
        bottom: 5px;
        /* afasta do rodapé */
        width: 100%;
        text-align: center;
        z-index: 3;
        /* acima das camadas */
        font-size: 0.9rem;
    }

    /* Animações de movimento */
    @keyframes moveBuild01 {
        from {
            background-position-x: 0;
        }

        to {
            background-position-x: -1000px;
        }
    }

    @keyframes moveBuild02 {
        from {
            background-position-x: 0;
        }

        to {
            background-position-x: -1000px;
        }
    }
</style>