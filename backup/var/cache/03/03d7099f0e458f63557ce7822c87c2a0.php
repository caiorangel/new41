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

/* @theme/sections/generators.twig */
class __TwigTemplate_80c5188e9f55fae9f3756463b1e2eadb extends Template
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
        yield "<div id=\"product\">
  <h2 class=\"text-center enter\">
    ";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Meet your ultimate"), "html", null, true);
        yield "

    <div class=\"from-[#D3F36B] to-[#6BAAF3] bg-gradient-to-r bg-clip-text\">
      ";
        // line 6
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "AI-Powered Content Platform"), "html", null, true);
        yield "
    </div>
  </h2>

  <div class=\"flex flex-col gap-6 mt-6 md:mt-12 md:gap-10\">
    ";
        // line 11
        yield from         $this->loadTemplate("@theme/sections/writer.twig", "@theme/sections/generators.twig", 11)->unwrap()->yield($context);
        // line 12
        yield "    ";
        yield from         $this->loadTemplate("@theme/sections/presets.twig", "@theme/sections/generators.twig", 12)->unwrap()->yield($context);
        // line 13
        yield "    ";
        yield from         $this->loadTemplate("@theme/sections/code.twig", "@theme/sections/generators.twig", 13)->unwrap()->yield($context);
        // line 14
        yield "    ";
        yield from         $this->loadTemplate("@theme/sections/image.twig", "@theme/sections/generators.twig", 14)->unwrap()->yield($context);
        // line 15
        yield "    ";
        yield from         $this->loadTemplate("@theme/sections/chat.twig", "@theme/sections/generators.twig", 15)->unwrap()->yield($context);
        // line 16
        yield "
    <div class=\"grid gap-5 md:gap-12 md:grid-cols-2 enter\">
      ";
        // line 18
        yield from         $this->loadTemplate("@theme/sections/speech-to-text.twig", "@theme/sections/generators.twig", 18)->unwrap()->yield($context);
        // line 19
        yield "      ";
        yield from         $this->loadTemplate("@theme/sections/text-to-voice.twig", "@theme/sections/generators.twig", 19)->unwrap()->yield($context);
        // line 20
        yield "    </div>
  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/generators.twig";
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
        return array (  79 => 20,  76 => 19,  74 => 18,  70 => 16,  67 => 15,  64 => 14,  61 => 13,  58 => 12,  56 => 11,  48 => 6,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/generators.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/generators.twig");
    }
}
