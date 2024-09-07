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

/* @theme/sections/writer.twig */
class __TwigTemplate_f5924609acdfdc5d4b241bd0aa4be760 extends Template
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
        yield "<div class=\"grid grid-cols-1 p-3 md:grid-cols-2 wrapper enter\">
  <div class=\"relative md:order-2\">
    <img src=\"";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("writer.webp"), "html", null, true);
        yield "\" alt=\"Text Generator\"
      class=\"dark:hidden\" width=\"1272\" height=\"1065\">

    <img src=\"";
        // line 6
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("writer-dark.webp"), "html", null, true);
        yield "\" alt=\"Text Generator\"
      class=\"hidden dark:block\" width=\"1323\" height=\"1095\">

    <div class=\"float top-1/2 -left-6 rotate-[15deg]\">
      <span class=\"icon shadow-left text-[#8B6BF3]\">
        <i class=\"ti ti-click\"></i>
      </span>
    </div>

    <div class=\"float -top-3 -right-6 rotate-[-15deg]\">
      <span class=\"icon shadow-right text-[#9FF37B]\">
        <i class=\"ti ti-bulb\"></i>
      </span>
    </div>
  </div>

  <div class=\"flex items-center\">
    <div class=\"w-full max-w-xl p-9\">
      <div class=\"badge\">
        ";
        // line 25
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "AI Writer"), "html", null, true);
        yield "
      </div>

      <h3 class=\"mt-8\">
        ";
        // line 29
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Write SEO optimized blogs, sales emails and more..."), "html", null, true);
        yield "
      </h3>

      <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
        ";
        // line 33
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Achieve superior outcomes in a fraction of the time. At last, a writing tool that you'll genuinely utilize."), "html", null, true);
        yield "
      </p>

      <div class=\"mt-8 md:mt-10\">
        <a href=\"/#features\" class=\"gap-4 button button-primary\">
          ";
        // line 38
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "See all features"), "html", null, true);
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
        return "@theme/sections/writer.twig";
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
        return array (  92 => 38,  84 => 33,  77 => 29,  70 => 25,  48 => 6,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/writer.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/writer.twig");
    }
}
