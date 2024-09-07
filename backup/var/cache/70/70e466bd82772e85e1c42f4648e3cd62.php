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

/* @theme/sections/hero.twig */
class __TwigTemplate_1314b9205a6c914abf1663de9d7eb6f7 extends Template
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
        yield "<div class=\"text-center enter\">
  <h1 class=\"max-w-4xl mx-auto\">
    ";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Transforming ideas into AI generated masterpieces"), "html", null, true);
        yield "
  </h1>

  <p class=\"max-w-3xl mx-auto mt-4 md:text-lg lg:text-xl text-secondary\">
    ";
        // line 7
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Effortlessly generate high-quality AI-driven content tailored to your needs. Unlock limitless possibilities, save your time and start making money today!"), "html", null, true);
        yield "
  </p>

  <div class=\"mt-10\">
    ";
        // line 11
        if (array_key_exists("user", $context)) {
            // line 12
            yield "    <a href=\"/app\" class=\"gap-4 button button-primary\">
      ";
            // line 13
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Go to app"), "html", null, true);
            yield "

      <i class=\"text-2xl ti ti-arrow-right\"></i>
    </a>
    ";
        } else {
            // line 18
            yield "    <a href=\"/signup\" class=\"gap-4 button button-primary\">
      ";
            // line 19
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Get started now"), "html", null, true);
            yield "

      <i class=\"text-2xl ti ti-arrow-right\"></i>
    </a>
    ";
        }
        // line 24
        yield "  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/hero.twig";
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
        return array (  80 => 24,  72 => 19,  69 => 18,  61 => 13,  58 => 12,  56 => 11,  49 => 7,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/hero.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/hero.twig");
    }
}
