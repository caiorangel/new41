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

/* /layouts/minimal.twig */
class __TwigTemplate_1cf4cfeaa61a8d92e605c1ce2e16982c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'layout' => [$this, 'block_layout'],
            'template' => [$this, 'block_template'],
            'scripts' => [$this, 'block_scripts'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "/layouts/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("/layouts/base.twig", "/layouts/minimal.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_layout($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "<div>
  <div class=\"container\">
    <div class=\"flex flex-col max-w-xl mx-auto md:gap-4\">
      ";
        // line 7
        yield from         $this->loadTemplate("sections/header.twig", "/layouts/minimal.twig", 7)->unwrap()->yield($context);
        // line 8
        yield "
      <div>
        ";
        // line 10
        yield from $this->unwrap()->yieldBlock('template', $context, $blocks);
        // line 11
        yield "        ";
        yield from         $this->loadTemplate("/sections/footer.twig", "/layouts/minimal.twig", 11)->unwrap()->yield($context);
        // line 12
        yield "      </div>
    </div>
  </div>
</div>
";
        return; yield '';
    }

    // line 10
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 18
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 19
        yield "<script src=\"assets/app.js?v=";
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
        yield "\"></script>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/layouts/minimal.twig";
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
        return array (  89 => 19,  85 => 18,  78 => 10,  69 => 12,  66 => 11,  64 => 10,  60 => 8,  58 => 7,  53 => 4,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/layouts/minimal.twig", "/home/u489518759/domains/renvon.com/resources/views/layouts/minimal.twig");
    }
}
