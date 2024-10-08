<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* snippets/install/success.twig */
class __TwigTemplate_6da2f5e9364929e1db0fefadb018919b extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        yield "<div class=\"flex flex-col gap-6 text-center\">
    <div
        class=\"relative flex items-center justify-center mx-auto rounded-full w-28 h-28 text-line-dimmed shrink-0\">

        <svg class=\"absolute top-0 left-0 w-full h-full\" width=\"112\"
            height=\"112\" viewBox=\"0 0 112 112\" fill=\"none\"
            xmlns=\"http://www.w3.org/2000/svg\">
            <circle cx=\"56\" cy=\"56\" r=\"55.5\" stroke=\"currentColor\"
                stroke-dasharray=\"8 8\" />
        </svg>

        <div
            class=\"flex items-center justify-center w-24 h-24 transition-all rounded-full text-content-dimmed bg-line-dimmed\">
            <i
                class=\"text-5xl ti ti-square-rounded-check-filled text-success\"></i>
        </div>
    </div>

    <div>
        <h1>Installed successfully!</h1>
        <p class=\"mt-1 text-intermediate-content\">
            Your website is ready to use.
        </p>

        <a href=\"/login\" class=\"mt-4 button button-outline\">
            <i class=\"ti ti-login\"></i>
            Login to dashboard
        </a>
    </div>

    <p class=\"text-xs leading-5 text-content-dimmed\">
        High-fives all around! 🖐️ <br>
        <a href=\"https://aikeedo.com\" target=\"_blank\" class=\"text-info\">
            Help us
        </a>

        keep the positivity going by sharing your review!
    </p>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/install/success.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array ();
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/install/success.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/success.twig");
    }
}
