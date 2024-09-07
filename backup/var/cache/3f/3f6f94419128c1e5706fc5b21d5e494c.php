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

/* snippets/initializing.twig */
class __TwigTemplate_7cfecc6266a1570de761bb6bb8d13d23 extends Template
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
        yield "<div class=\"flex flex-col items-center gap-2 text-center\">
  <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"
    xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"32px\"
    height=\"32px\" viewBox=\"0 0 50 50\" style=\"enable-background:new 0 0 50 50;\"
    class=\"animate-spin\" xml:space=\"preserve\">
    <path fill=\"currentColor\"
      d=\"M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z\">
    </path>
  </svg>

  <span class=\"text-xs text-content-dimmed\">
    ";
        // line 12
        ((array_key_exists("text", $context)) ? (yield Twig\Extension\EscaperExtension::escape($this->env, ($context["text"] ?? null), "html", null, true)) : (yield "Initializing..."));
        yield "
  </span>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/initializing.twig";
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
        return array (  51 => 12,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/initializing.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/initializing.twig");
    }
}
