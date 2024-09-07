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

/* @theme/sections/chat.twig */
class __TwigTemplate_292fd272bfc8f04dfb906b29b440f528 extends Template
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
        yield "<div class=\"grid lg:mb-10 md:grid-cols-2 wrapper enter\">
  <div class=\"lg:py-6 md:order-2\">
    <img src=\"";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("chat.webp"), "html", null, true);
        yield "\" alt=\"AI Chat Bot\"
      class=\"translate-y-10 dark:hidden\" width=\"1458\" height=\"1198\">

    <img src=\"";
        // line 6
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("chat-dark.webp"), "html", null, true);
        yield "\" alt=\"AI Chat Bot\"
      class=\"hidden translate-y-10 dark:block\" width=\"1458\" height=\"1198\">
  </div>

  <div class=\"flex items-center\">
    <div class=\"w-full max-w-xl p-12\">
      <span class=\"badge\">
        ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "AI Chat Bot"), "html", null, true);
        yield "
      </span>

      <h3 class=\"mt-8\">
        ";
        // line 17
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "That's remarkably human-like and engaging..."), "html", null, true);
        yield "
      </h3>

      <p class=\"mt-3 font-medium md:mt-6 md:text-xl\">
        ";
        // line 21
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Simply choose your asistant and engage with a friendly chatbot to generate ideas, enhance your content, or even bring a smile to your face."), "html", null, true);
        yield "
      </p>

      <div class=\"mt-8 md:mt-14\">
        <a href=\"app/chat\" class=\"gap-4 button button-primary\">
          ";
        // line 26
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Try now"), "html", null, true);
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
        return "@theme/sections/chat.twig";
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
        return new Source("", "@theme/sections/chat.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/chat.twig");
    }
}
