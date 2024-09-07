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

/* @theme/sections/cta.twig */
class __TwigTemplate_1e6a6a8eb288956889aa95362719932d extends Template
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
        yield "<div
  class=\"rounded-4xl bg-contrast-accent bg-gradient-to-br from-[#E7FF9B] to-[#CFE6FF] p-[10px] relative enter\">
  <div class=\"text-center p-14 bg-contrast-primary rounded-3xl\">
    <h3>";
        // line 4
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Ready to level-up?"), "html", null, true);
        yield "</h3>
    <p class=\"mt-2 text-xl font-medium\">
      ";
        // line 6
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "See how easy it can be to write amazing content."), "html", null, true);
        yield "
    </p>

    <div class=\"mt-10\">
      <a href=\"/signup\" class=\"gap-4 button button-primary\">
        ";
        // line 11
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Get Started Now"), "html", null, true);
        yield "

        <i class=\"text-2xl ti ti-arrow-right\"></i>
      </a>
    </div>
  </div>

  <img src=\"";
        // line 18
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("cta1.webp"), "html", null, true);
        yield "\"
    class=\"w-[115px] absolute bottom-0 left-14 hidden lg:block\" alt=\"\"
    width=\"231\" height=\"648\">
  <img src=\"";
        // line 21
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("cta2.webp"), "html", null, true);
        yield "\"
    class=\"w-[150px] absolute top-0 right-14 hidden lg:block\" alt=\"\" width=\"300\"
    height=\"649\">
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/cta.twig";
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
        return array (  72 => 21,  66 => 18,  56 => 11,  48 => 6,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/cta.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/cta.twig");
    }
}
