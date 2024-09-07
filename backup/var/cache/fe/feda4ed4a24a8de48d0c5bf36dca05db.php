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

/* snippets/install/welcome.twig */
class __TwigTemplate_302b117148c3bb5debba77efc9b44ad0 extends Template
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
        // line 1
        yield "<x-form>
    <form class=\"flex flex-col gap-8\" @submit.prevent=\"viewRequirement()\">
        <h1>Aikeedo Installation</h1>

        <p class=\"text-intermediate-content\">
            Welcome! Aikeedo is an AI Powered Content Platform (web application)
            that allows
            you generate blogs, social media content, marketing emails,
            programming
            codes, images and more.
        </p>

        <p class=\"flex items-center gap-2 text-sm text-intermediate-content\">
            Installation process is very easy and it takes less than a minute!
            <i class=\"text-xl ti ti-sparkles text-success\"></i>
        </p>

        <button type=\"submit\" class=\"w-full button group\"
            :processing=\"isProcessing\">
            ";
        // line 20
        yield from         $this->loadTemplate("snippets/spinner.twig", "snippets/install/welcome.twig", 20)->unwrap()->yield($context);
        // line 21
        yield "
            Start installation
        </button>
    </form>
</x-form>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/install/welcome.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  61 => 21,  59 => 20,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/install/welcome.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/welcome.twig");
    }
}
