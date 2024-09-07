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

/* snippets/back.twig */
class __TwigTemplate_699e331c94756c709f16bcfa883bd829 extends Template
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
        yield "<a href=\"";
        (((array_key_exists("link", $context) &&  !(null === ($context["link"] ?? null)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, ($context["link"] ?? null), "html", null, true)) : (yield "#"));
        yield "\"
  class=\"inline-flex items-center gap-1 text-sm text-content-dimmed hover:text-content\">
  <i class=\"text-lg ti ti-";
        // line 3
        (((array_key_exists("icon", $context) &&  !(null === ($context["icon"] ?? null)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, ($context["icon"] ?? null), "html", null, true)) : (yield "square-rounded-arrow-left-filled"));
        yield "\"></i>
  ";
        // line 4
        yield Twig\Extension\EscaperExtension::escape($this->env, ((array_key_exists("label", $context)) ? (($context["label"] ?? null)) : (p__("button", "Back"))), "html", null, true);
        yield "
</a>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/back.twig";
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
        return array (  48 => 4,  44 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/back.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/back.twig");
    }
}
