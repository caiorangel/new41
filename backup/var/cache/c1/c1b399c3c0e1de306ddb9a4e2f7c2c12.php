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

/* @theme/snippets/script-tags/end.twig */
class __TwigTemplate_c909a621d9f7081ae0b8113791fa7c32 extends Template
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
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 1), "custom", [], "any", false, true, false, 1), "end", [], "any", true, true, false, 1) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 1), "custom", [], "any", false, false, false, 1), "end", [], "any", false, false, false, 1))) {
            // line 2
            yield Twig\Extension\CoreExtension::include($this->env, $context, $this->env->getFunction('template')->getCallable()($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 2), "custom", [], "any", false, false, false, 2), "end", [], "any", false, false, false, 2)));
            yield "
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/snippets/script-tags/end.twig";
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
        return array (  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/snippets/script-tags/end.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/snippets/script-tags/end.twig");
    }
}
