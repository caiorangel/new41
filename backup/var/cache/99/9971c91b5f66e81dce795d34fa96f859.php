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

/* /snippets/spinner.twig */
class __TwigTemplate_58f0bdd7dce337f343298585544ad9e7 extends Template
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
        yield "<svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"
  xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"24px\"
  height=\"24px\" viewBox=\"0 0 50 50\" style=\"enable-background:new 0 0 50 50;\"
  class=\"spinner\" xml:space=\"preserve\">
  <path fill=\"currentColor\"
    d=\"M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z\">
    <animateTransform attributeType=\"xml\" attributeName=\"transform\"
      type=\"rotate\" from=\"0 25 25\" to=\"360 25 25\" dur=\"0.6s\"
      repeatCount=\"indefinite\"></animateTransform>
  </path>
</svg>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/snippets/spinner.twig";
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
        return new Source("", "/snippets/spinner.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/spinner.twig");
    }
}
