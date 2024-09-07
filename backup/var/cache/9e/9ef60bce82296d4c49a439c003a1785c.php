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

/* @theme/sections/preview.twig */
class __TwigTemplate_926e6aaa3e7f3fcb4bbb997900f5a091 extends Template
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
        yield "<div class=\"wrapper enter\">
  <img src=\"";
        // line 2
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("preview.webp"), "html", null, true);
        yield "\" alt=\"Application preview\"
    width=\"2400\" height=\"1480\" class=\"rounded-3xl dark:hidden\">

  <img src=\"";
        // line 5
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("preview-dark.webp"), "html", null, true);
        yield "\" alt=\"Application preview\"
    width=\"2400\" height=\"1480\" class=\"hidden rounded-3xl dark:block\">

  <div class=\"float -top-3 -left-6 -rotate-[15deg]\">
    <span class=\"icon shadow-right text-[#30C862]\">
      <i class=\"ti ti-topology-star\"></i>
    </span>
  </div>

  <div class=\"-mt-6 -ml-6 float top-full left-1/2 -rotate-[10deg]\">
    <span class=\"icon shadow-right text-[#00A6FB]\">
      <i class=\"ti ti-carousel-horizontal\"></i>
    </span>
  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/preview.twig";
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
        return array (  47 => 5,  41 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/preview.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/preview.twig");
    }
}
