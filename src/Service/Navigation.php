<?php

namespace App\Service;

use Twig\Environment;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Navigation {

    private $request;
    private $logger;
    private $templatePath;
    private $tokenStorage;

    public function __construct(RequestStack $request, Environment $twig, $templatePath, TokenStorageInterface $tokenStorage) {
        $this->request = $request;
        $this->twig = $twig;
        $this->templatePath = $templatePath;
        $this->tokenStorage = $tokenStorage;
    }

    public function setTemplatePath($templatePath) {
        $this->templatePath = $templatePath;
        return $this;
    }

    public function getTemplatePath() {
        return $this->templatePath;
    }
    // Récup le chemin courant
    public function getCurrentPath() {
        return $this->request->getCurrentRequest()->attributes->get('_route');
    }
    // Recup le chemin courant en lui appliquant des transformations
    public function getPath() {
        return strtoupper(str_replace("_", " ", $this->getCurrentPath()));
    }

    public function display() {
        $this->twig->display($this->templatePath, [
            'currentPath' => $this->getCurrentPath(),
            'path' => $this->getPath(),
            // Récuperer l'utilisateur courant
            'user' => $this->tokenStorage->getToken()->getUser(),
        ]);
    }

}