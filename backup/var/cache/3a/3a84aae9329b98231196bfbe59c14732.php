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

/* /sections/footer.twig */
class __TwigTemplate_e8e410ad9f2435d726f2a188572970a0 extends Template
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
        yield "<footer class=\"py-4 text-xs text-center text-content-dimmed bg-main\">
  ";
        // line 2
        yield Twig\Extension\EscaperExtension::escape($this->env, __("All rights reserved."), "html", null, true);
        yield "
  ";
        // line 3
        yield __("&copy; %s", Twig\Extension\CoreExtension::dateFormatFilter($this->env, "now", "Y"));
        yield "
  ";
        // line 4
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 4), "name", [], "any", true, true, false, 4) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 4), "name", [], "any", false, false, false, 4)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 4), "name", [], "any", false, false, false, 4), "html", null, true)) : (yield ""));
        yield " | ";
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Version %s", ($context["version"] ?? null)), "html", null, true);
        yield "
</footer>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/sections/footer.twig";
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
        return array (  49 => 4,  45 => 3,  41 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/sections/footer.twig", "/home/u489518759/domains/renvon.com/resources/views/sections/footer.twig");
    }
}
