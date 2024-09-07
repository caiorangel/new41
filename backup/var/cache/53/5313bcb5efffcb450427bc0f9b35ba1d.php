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

/* templates/404.twig */
class __TwigTemplate_f3c92bb2e2e994be2d725bed26ba30d8 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'template' => [$this, 'block_template'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "/layouts/minimal.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("/layouts/minimal.twig", "templates/404.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Not found")), "html", null, true);
        return; yield '';
    }

    // line 5
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        yield "<section class=\"xs:p-8 box md:px-14\">
  ";
        // line 7
        if (array_key_exists("user", $context)) {
            // line 8
            yield "  ";
            yield from             $this->loadTemplate("snippets/back.twig", "templates/404.twig", 8)->unwrap()->yield(CoreExtension::arrayMerge($context, ["link" => "app", "label" => p__("button", "Go to app")]));
            // line 9
            yield "  ";
        } else {
            // line 10
            yield "  ";
            yield from             $this->loadTemplate("snippets/back.twig", "templates/404.twig", 10)->unwrap()->yield(CoreExtension::arrayMerge($context, ["link" => "/", "label" => p__("button", "Go to home page")]));
            // line 11
            yield "  ";
        }
        // line 12
        yield "
  <h1 class=\"mt-4 text-xl font-bold md:text-2xl\">
    ";
        // line 14
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Page not found"), "html", null, true);
        yield "
  </h1>

  <p class=\"mt-2\">";
        // line 17
        yield Twig\Extension\EscaperExtension::escape($this->env, __("The page you are looking for does not exist."), "html", null, true);
        yield "</p>
</section>

";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "templates/404.twig";
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
        return array (  87 => 17,  81 => 14,  77 => 12,  74 => 11,  71 => 10,  68 => 9,  65 => 8,  63 => 7,  60 => 6,  56 => 5,  48 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "templates/404.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/404.twig");
    }
}
