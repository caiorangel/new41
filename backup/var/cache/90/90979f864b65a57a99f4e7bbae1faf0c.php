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

/* @theme/sections/presets.twig */
class __TwigTemplate_c653ca8ca7cbc3a9f121b0415ae1b7ec extends Template
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
  class=\"rounded-4xl bg-primary bg-gradient-to-b to-[#000009] from-[#48515D] p-[10px] enter\">
  <div
    class=\"grid md:grid-cols-2 p-3 bg-contrast-primary text-contrast-primary dark:text-primary bg-gradient-to-tr from-[#171E27] to-[#48515D] rounded-3xl relative overflow-hidden\">
    <div class=\"relative z-10 flex items-center\">
      <div class=\"w-full py-12 md:py-40 px-9\">
        <div class=\"badge bg-secondary dark:bg-line-tertiary text-tertiary\">
          <span class=\"text-contrast-primary dark:text-primary\">
            ";
        // line 9
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "100+ AI Writer Templates"), "html", null, true);
        yield "
          </span>
        </div>

        <h3 class=\"mt-8\">
          ";
        // line 14
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "What can Writing Assistant create for you?"), "html", null, true);
        yield "
        </h3>

        <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
          ";
        // line 18
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Write with remarkable speed, captivate your audience, and bid farewell to writer's block forever."), "html", null, true);
        yield "
        </p>

        <div class=\"mt-8 md:mt-10\">
          <a href=\"/signup\" class=\"button\">
            ";
        // line 23
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Get Started for Free"), "html", null, true);
        yield "
          </a>
        </div>
      </div>
    </div>

    <div class=\"scrolling-presets\">
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
        return "@theme/sections/presets.twig";
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
        return array (  71 => 23,  63 => 18,  56 => 14,  48 => 9,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/presets.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/presets.twig");
    }
}
