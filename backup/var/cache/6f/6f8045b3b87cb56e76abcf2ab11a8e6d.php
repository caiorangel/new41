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

/* /layouts/main.twig */
class __TwigTemplate_a78445b97364d05c1dc3fb84b47ad948 extends Template
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
            'footer' => [$this, 'block_footer'],
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
        $this->parent = $this->loadTemplate("/layouts/base.twig", "/layouts/main.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_layout($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        yield "<div class=\"lg:flex lg:items-start lg:min-h-screen\">
  ";
        // line 5
        yield from         $this->loadTemplate("/sections/aside.twig", "/layouts/main.twig", 5)->unwrap()->yield($context);
        // line 6
        yield "
  <div
    class=\"sticky top-0 z-30 block mb-4 border-b lg:hidden bg-main border-line-dimmed group-data-[mobile-menu]/html:border-0\">
    <div class=\"w-full max-w-4xl mx-auto\">
      ";
        // line 10
        yield from         $this->loadTemplate("/sections/mobile-nav.twig", "/layouts/main.twig", 10)->unwrap()->yield($context);
        // line 11
        yield "    </div>
  </div>

  <div class=\"container\">
    <div
      class=\"flex flex-col md:pt-10 min-h-screen grow group-data-[mobile-menu]/html:hidden lg:group-data-[mobile-menu]/html:flex w-full mx-auto max-w-4xl\">
      <main class=\"flex flex-col gap-5 grow md:gap-8\">
        ";
        // line 18
        yield from $this->unwrap()->yieldBlock('template', $context, $blocks);
        // line 19
        yield "      </main>

      ";
        // line 21
        yield from $this->unwrap()->yieldBlock('footer', $context, $blocks);
        // line 24
        yield "    </div>
  </div>
</div>

";
        // line 28
        yield from         $this->loadTemplate("/snippets/workspace/switcher.twig", "/layouts/main.twig", 28)->unwrap()->yield($context);
        return; yield '';
    }

    // line 18
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 21
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 22
        yield "      ";
        yield from         $this->loadTemplate("/sections/footer.twig", "/layouts/main.twig", 22)->unwrap()->yield($context);
        // line 23
        yield "      ";
        return; yield '';
    }

    // line 31
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 32
        if (CoreExtension::inFilter(($context["view_namespace"] ?? null), ["app", "admin"])) {
            // line 33
            yield "<script src=\"assets/";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["view_namespace"] ?? null), "html", null, true);
            yield ".js?v=";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
            yield "\"></script>
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/layouts/main.twig";
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
        return array (  120 => 33,  118 => 32,  114 => 31,  109 => 23,  106 => 22,  102 => 21,  95 => 18,  90 => 28,  84 => 24,  82 => 21,  78 => 19,  76 => 18,  67 => 11,  65 => 10,  59 => 6,  57 => 5,  54 => 4,  50 => 3,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/layouts/main.twig", "/home/u489518759/domains/renvon.com/resources/views/layouts/main.twig");
    }
}
