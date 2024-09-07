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

/* @theme/sections/image.twig */
class __TwigTemplate_6a67a2d51d78490df54968baa5a4fd56 extends Template
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
        yield "<div class=\"relative lg:my-10 wrapper enter\" id=\"image-generator\">
  <div class=\"relative z-10 flex items-center lg:w-1/2\">
    <div class=\"w-full max-w-xl px-12 py-12 md:py-40\">
      <div class=\"badge\">
        ";
        // line 5
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "AI Image"), "html", null, true);
        yield "
      </div>

      <h3 class=\"mt-8\">
        ";
        // line 9
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Visualize what you dream of. Create images from text."), "html", null, true);
        yield "
      </h3>

      <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
        ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Instantly create stunning images using AI Image Generator – your tool for artistic innovation."), "html", null, true);
        yield "
      </p>

      <div class=\"mt-8 md:mt-10\">
        <a href=\"/signup\" class=\"gap-4 button button-primary\">
          ";
        // line 18
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Try for free"), "html", null, true);
        yield "

          <i class=\"text-2xl ti ti-arrow-right\"></i>
        </a>
      </div>
    </div>
  </div>

  <div class=\"absolute top-0 right-0 w-full h-full lg:w-1/2\">
    <div class=\"grid grid-cols-4 gap-4 pl-4 pr-4 lg:pl-0 preview\">
      <div class=\"bg\">
        <div>
        </div>
      </div>

      <div class=\"bg\">
        <div>
        </div>
      </div>

      <div class=\"bg\">
        <div>
        </div>
      </div>

      <div class=\"bg\">
        <div>
        </div>
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
        return "@theme/sections/image.twig";
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
        return array (  66 => 18,  58 => 13,  51 => 9,  44 => 5,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/image.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/image.twig");
    }
}
