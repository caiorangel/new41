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

/* /templates/auth/callback.twig */
class __TwigTemplate_33cd4a6fbfa9ffea95debdc0f4338cbb extends Template
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
            'scripts' => [$this, 'block_scripts'],
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
        $this->parent = $this->loadTemplate("/layouts/minimal.twig", "/templates/auth/callback.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Authentication")), "html", null, true);
        return; yield '';
    }

    // line 5
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 6
        yield "<div class=\"box\" data-density=\"comfortable\">
  ";
        // line 7
        yield from         $this->loadTemplate("snippets/initializing.twig", "/templates/auth/callback.twig", 7)->unwrap()->yield(CoreExtension::toArray(["text" => __("Authenticating...")]));
        // line 8
        yield "</div>
";
        return; yield '';
    }

    // line 11
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 12
        yield "<script>
  // Save the JWT to local storage to be used for future api requests
  localStorage.setItem('jwt', '";
        // line 14
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["jwt"] ?? null), "html", null, true);
        yield "');
  window.location.href = 'app';
</script>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/templates/auth/callback.twig";
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
        return array (  80 => 14,  76 => 12,  72 => 11,  66 => 8,  64 => 7,  61 => 6,  57 => 5,  49 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/templates/auth/callback.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/auth/callback.twig");
    }
}
