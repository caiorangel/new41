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

/* @theme/sections/speech-to-text.twig */
class __TwigTemplate_f2f96d0eb1147bddedf8a19402685fb2 extends Template
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
        yield "<div class=\"flex flex-col justify-between wrapper\">
  <div class=\"p-12\">
    <span class=\"badge\">
      ";
        // line 4
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Speech to Text"), "html", null, true);
        yield "
    </span>

    <h3 class=\"mt-8\">
      ";
        // line 8
        yield dp__("theme", "heading", "Transforming Spoken <br> Words into Text.");
        yield "
    </h3>

    <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
      ";
        // line 12
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Instantly Transcribe Spoken Words into Text for Enhanced Productivity and Accessibility."), "html", null, true);
        yield "
    </p>

    <div class=\"mt-8 md:mt-10\">
      <a href=\"/signup\" class=\"gap-4 button button-primary\">
        ";
        // line 17
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Convert now"), "html", null, true);
        yield "

        <i class=\"text-2xl ti ti-arrow-right\"></i>
      </a>
    </div>
  </div>

  <div class=\"mx-0.5\">
    <img src=\"";
        // line 25
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("speech-to-text.webp"), "html", null, true);
        yield "\"
      alt=\"AI speech to text transformer\" class=\"dark:hidden\" width=\"1138\"
      height=\"1046\">

    <img src=\"";
        // line 29
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("speech-to-text-dark.webp"), "html", null, true);
        yield "\"
      alt=\"AI speech to text transformer\" class=\"hidden dark:block\" width=\"1138\"
      height=\"1046\">
  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/speech-to-text.twig";
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
        return array (  83 => 29,  76 => 25,  65 => 17,  57 => 12,  50 => 8,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/speech-to-text.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/speech-to-text.twig");
    }
}
