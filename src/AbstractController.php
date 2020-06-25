<?php

namespace Ridem;

use finfo;

abstract class AbstractController
{
    private $templateEngine;

    private $_flashbag;


    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__, 4) . '/templates');
        $this->templateEngine = new \Twig\Environment($loader);
    }


    protected function render($view, $vars = [])
    {

        return $this->templateEngine->render(
            $view . '.html.twig',
            array_merge(
                $vars,
                ['session' => $_SESSION]
            )
        );
    }

    protected function flashbag()
    {
        if ($this->_flashbag === null) {
            $this->_flashbag = new FlashBag();
        }
        return $this->_flashbag;
    }

    protected function redirectToRoute(string $url)
    {
        header("Location: " . $url);
        exit();
    }

    protected function blobify($file)
    {
        $finfo = new finfo(FILEINFO_MIME_TYPE);

        if (array_search(
            $finfo->file($file),
            array(
                'jpg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
            ),
            true
        )) {
            $img = addslashes($file);
            $img = file_get_contents($img);
            $img = base64_encode($img);
            return $img;
        } else {
            return false;
        }
    }
}
