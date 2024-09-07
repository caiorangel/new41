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

/* /snippets/sso.twig */
class __TwigTemplate_c4ed78f3c1a0ab5f614b431c4d0cbb6d extends Template
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
        $context["count"] = Twig\Extension\CoreExtension::lengthFilter($this->env, ($context["identity_providers"] ?? null));
        // line 2
        if ((($context["count"] ?? null) > 0)) {
            // line 3
            yield "<div
  class=\"relative flex justify-center text-xs text-content-dimmed before:absolute before:left-0 before:top-1/2 before:w-full before:h-px before:bg-line-dimmed\">
  <span class=\"relative z-10 px-4 bg-main\">";
            // line 5
            yield Twig\Extension\EscaperExtension::escape($this->env, __("or continue with"), "html", null, true);
            yield "</span>
</div>

<div class=\"flex flex-wrap items-center gap-4\" x-init=\"ipinfo\">
  ";
            // line 9
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["identity_providers"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["provider"]) {
                // line 10
                yield "  <a href=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["provider"], "getAuthUrl", [], "method", false, false, false, 10), "html", null, true);
                yield "\"
    class=\"flex-1 p-0 button button-outline min-w-[3rem]\">
    <img src=\"";
                // line 12
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["provider"], "getIconSrc", [], "method", false, false, false, 12), "html", null, true);
                yield "\" alt=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["provider"], "getName", [], "method", false, false, false, 12), "html", null, true);
                yield "\"
      class=\"object-contain w-6 h-6\">

    ";
                // line 15
                if ((($context["count"] ?? null) < 3)) {
                    // line 16
                    yield "    ";
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["provider"], "getName", [], "method", false, false, false, 16), "html", null, true);
                    yield "
    ";
                }
                // line 18
                yield "  </a>
  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['provider'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 20
            yield "</div>
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/snippets/sso.twig";
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
        return array (  86 => 20,  79 => 18,  73 => 16,  71 => 15,  63 => 12,  57 => 10,  53 => 9,  46 => 5,  42 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/snippets/sso.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/sso.twig");
    }
}
