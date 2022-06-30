<?php
namespace App\Controllers;

abstract class Controller {
    public \Twig\Environment $renderingEngine;

    public function setTemplatingEngine(\Twig\Environment $environment) {
        $this->renderingEngine = $environment;
    }
}