<?php

if (!function_exists('url_exists')) {
    /**
     * Checa se uma URL existe (responde com código HTTP 200-399)
     *
     * @param string $url
     * @return bool
     */
    function url_exists(string $url): bool
    {
        // cria/limpa a variável global de erro
        $GLOBALS['url_exists_error'] = null;

        if (empty($url)) {
            $GLOBALS['url_exists_error'] = "URL vazia.";
            return false;
        }

        $ch = curl_init($url);

        // Configuração da requisição
        curl_setopt($ch, CURLOPT_NOBODY, true);   // não precisa do corpo
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);    // tempo máximo
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // seguir redirecionamentos
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignora SSL inválido
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $exec = curl_exec($ch);

        if ($exec === false) {
            $GLOBALS['url_exists_error'] = curl_error($ch);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 400) {
            $GLOBALS['url_exists_error'] = "HTTP Code {$httpCode}";
            return false;
        }

        return true;
    }
}
