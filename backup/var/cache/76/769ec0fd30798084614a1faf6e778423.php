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

/* @theme/sections/code.twig */
class __TwigTemplate_496dad4bc2e2f5c00573913d233b0979 extends Template
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
        yield "<div class=\"grid md:grid-cols-2 wrapper enter\">
  <div class=\"py-3 md:order-2\">
    <img src=\"";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("code.webp"), "html", null, true);
        yield "\" alt=\"Code Generator\"
      class=\"dark:hidden\" width=\"1262\" height=\"1161\">

    <img src=\"";
        // line 6
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("code-dark.webp"), "html", null, true);
        yield "\" alt=\"Code Generator\"
      class=\"hidden dark:block\" width=\"1262\" height=\"1161\">
  </div>

  <div class=\"flex items-center\">
    <div class=\"w-full max-w-xl p-12\">
      <div class=\"badge\">
        ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "AI Code"), "html", null, true);
        yield "
      </div>

      <h3 class=\"mt-8\">
        ";
        // line 17
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Ready to write code at the speed of light?"), "html", null, true);
        yield "
      </h3>

      <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
        ";
        // line 21
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Effortless coding with AI Code Generator: Instant solutions for your programming needs."), "html", null, true);
        yield "
      </p>

      <div class=\"mt-8 md:mt-10\">
        <a href=\"/signup\" class=\"gap-4 button button-primary\">
          ";
        // line 26
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Start Generate Code"), "html", null, true);
        yield "

          <i class=\"text-2xl ti ti-arrow-right\"></i>
        </a>
      </div>
    </div>
  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/code.twig";
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
        return array (  80 => 26,  72 => 21,  65 => 17,  58 => 13,  48 => 6,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/code.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/code.twig");
    }
}
