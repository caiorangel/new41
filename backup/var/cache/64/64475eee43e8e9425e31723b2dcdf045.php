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

/* @theme/templates/index.twig */
class __TwigTemplate_e39be53adc9c663795eac04f6bfb3dbf extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'template' => [$this, 'block_template'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@theme/layouts/theme.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("@theme/layouts/theme.twig", "@theme/templates/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "<div class=\"flex flex-col gap-6 my-10 md:my-20 md:gap-12 lg:gap-24\">
  ";
        // line 5
        yield from         $this->loadTemplate("@theme/sections/hero.twig", "@theme/templates/index.twig", 5)->unwrap()->yield($context);
        // line 6
        yield "  ";
        yield from         $this->loadTemplate("@theme/sections/preview.twig", "@theme/templates/index.twig", 6)->unwrap()->yield($context);
        // line 7
        yield "  ";
        yield from         $this->loadTemplate("@theme/sections/generators.twig", "@theme/templates/index.twig", 7)->unwrap()->yield($context);
        // line 8
        yield "
  ";
        // line 9
        yield from         $this->loadTemplate("@theme/sections/how-it-works.twig", "@theme/templates/index.twig", 9)->unwrap()->yield($context);
        // line 10
        yield "  ";
        yield from         $this->loadTemplate("@theme/sections/features.twig", "@theme/templates/index.twig", 10)->unwrap()->yield($context);
        // line 11
        yield "  ";
        yield from         $this->loadTemplate("@theme/sections/pricing.twig", "@theme/templates/index.twig", 11)->unwrap()->yield($context);
        // line 12
        yield "  ";
        yield from         $this->loadTemplate("@theme/sections/cta.twig", "@theme/templates/index.twig", 12)->unwrap()->yield($context);
        // line 13
        yield "</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/templates/index.twig";
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
        return array (  76 => 13,  73 => 12,  70 => 11,  67 => 10,  65 => 9,  62 => 8,  59 => 7,  56 => 6,  54 => 5,  51 => 4,  47 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/templates/index.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/templates/index.twig");
    }
}
