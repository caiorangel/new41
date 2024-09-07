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

/* @theme/sections/text-to-voice.twig */
class __TwigTemplate_9f91a110101938f87e8aba9b37d20434 extends Template
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
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Text to Voice"), "html", null, true);
        yield "
    </span>

    <h3 class=\"mt-8\">
      ";
        // line 8
        yield dp__("theme", "heading", "Convert your texts into <br> Lifelike Speech");
        yield "
    </h3>

    <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
      ";
        // line 12
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Elevate Your Content with Expressive Narration: Discover Text-to-Voice Excellence."), "html", null, true);
        yield "
    </p>
  </div>

  <div class=\"mx-4 mb-2\">
    <img src=\"";
        // line 17
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("text-to-voice.webp"), "html", null, true);
        yield "\"
      alt=\"AI text to voice transformer\" class=\"dark:hidden\" width=\"1099\"
      height=\"999\">

    <img src=\"";
        // line 21
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("text-to-voice-dark.webp"), "html", null, true);
        yield "\"
      alt=\"AI text to voice transformer\" class=\"hidden dark:block\" width=\"1099\"
      height=\"999\">
  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/text-to-voice.twig";
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
        return array (  72 => 21,  65 => 17,  57 => 12,  50 => 8,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/text-to-voice.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/text-to-voice.twig");
    }
}
