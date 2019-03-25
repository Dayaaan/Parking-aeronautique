<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class Navigation {

    private $request;
    private $logger;
    private $templatePath;

    public function __construct(RequestStack $request, Environment $twig, $templatePath) {
        $this->request = $request;
        $this->twig = $twig;
        $this->templatePath = $templatePath;
    }

    public function setTemplatePath($templatePath) {
        $this->templatePath = $templatePath;
        return $this;
    }

    public function getTemplatePath() {
        return $this->templatePath;
    }

    public function getCurrentPath() {
        return $this->request->getCurrentRequest()->attributes->get('_route');
    }

    public function getPath() {
        return strtoupper(str_replace("_", " ", $this->getCurrentPath()));
    }

    public function display() {
        $this->twig->display($this->templatePath, [
            'currentPath' => $this->getCurrentPath(),
            'path' => $this->getPath(),
        ]);
    }

}