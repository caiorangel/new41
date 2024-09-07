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

/* @theme/sections/how-it-works.twig */
class __TwigTemplate_c537b81e31bdd4176b6888e9c0970dab extends Template
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
        yield "<div>
  <h2 class=\"text-center enter\">
    ";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "How it works"), "html", null, true);
        yield "
  </h2>

  <div class=\"grid gap-6 mt-6 md:gap-12 lg:mt-10 lg:grid-cols-3\">
    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-click\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Choose Template"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 16
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Choose a our built in templates or create your own."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-list-details\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 26
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Describe"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 29
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Enter a few sentences to describe your topic. Add keywords to specify for your brand."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-loader-3\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 39
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Generate"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 42
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Click the \"Generate\" button and get a variety of high-converting copy every time."), "html", null, true);
        yield "
      </p>
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
        return "@theme/sections/how-it-works.twig";
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
        return array (  99 => 42,  93 => 39,  80 => 29,  74 => 26,  61 => 16,  55 => 13,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/how-it-works.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/how-it-works.twig");
    }
}
