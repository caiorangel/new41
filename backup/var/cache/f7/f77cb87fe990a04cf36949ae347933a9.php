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

/* /templates/app/dashboard.twig */
class __TwigTemplate_4e21df9305916126ea3d1164318ca70c extends Template
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
        return "/layouts/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        $context["active_menu"] = "dashboard";
        // line 4
        $context["xdata"] = "dashboard";
        // line 1
        $this->parent = $this->loadTemplate("/layouts/main.twig", "/templates/app/dashboard.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Dashboard")), "html", null, true);
        return; yield '';
    }

    // line 7
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        yield "<h1>
  <span
    class=\"block text-sm font-normal text-content-dimmed\">";
        // line 10
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Welcome"), "html", null, true);
        yield "</span>

  <span class=\"block\">
    ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 13), "html", null, true);
        yield " ";
        yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 13), "html", null, true);
        yield "
  </span>
</h1>


<div class=\"flex flex-col gap-1\">
  <div class=\"mb-3\">
    ";
        // line 20
        yield from         $this->loadTemplate("sections/dashboard/search.twig", "/templates/app/dashboard.twig", 20)->unwrap()->yield($context);
        // line 21
        yield "  </div>

  ";
        // line 23
        if (((($context["environment"] ?? null) == "demo") && (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 23) == "admin"))) {
            // line 24
            yield "  <div
    class=\"px-4 py-2 text-xs font-bold border-2 rounded-md border-failure/25 bg-failure/10\">
    Sign up with your email to receive 100 free credits for testing app
    features. This demo admin account has no credits to use within the app.
  </div>
  ";
        }
        // line 30
        yield "
  ";
        // line 31
        if ((((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "is_email_verified", [], "any", false, false, false, 31) != true) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 31), "email_verification_policy", [], "any", true, true, false, 31)) && CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 31), "email_verification_policy", [], "any", false, false, false, 31), ["relaxed", "strict"]))) {
            // line 32
            yield "  <div class=\"flex items-center gap-2 box\">
    <i class=\"ti ti-alert-circle-filled text-failure\"></i>

    <div>
      ";
            // line 36
            yield Twig\Extension\EscaperExtension::escape($this->env, __("Your email address is not verified."), "html", null, true);
            yield "

      <a href=\"app/account/verification\" class=\"font-semibold hover:underline\">
        ";
            // line 39
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Verify email"), "html", null, true);
            yield "
      </a>
    </div>
  </div>
  ";
        }
        // line 44
        yield "
  ";
        // line 45
        yield from         $this->loadTemplate("sections/dashboard/billing.twig", "/templates/app/dashboard.twig", 45)->unwrap()->yield($context);
        // line 46
        yield "</div>

";
        // line 48
        yield from         $this->loadTemplate("sections/dashboard/tools.twig", "/templates/app/dashboard.twig", 48)->unwrap()->yield($context);
        // line 49
        yield from         $this->loadTemplate("sections/dashboard/documents.twig", "/templates/app/dashboard.twig", 49)->unwrap()->yield($context);
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/templates/app/dashboard.twig";
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
        return array (  139 => 49,  137 => 48,  133 => 46,  131 => 45,  128 => 44,  120 => 39,  114 => 36,  108 => 32,  106 => 31,  103 => 30,  95 => 24,  93 => 23,  89 => 21,  87 => 20,  75 => 13,  69 => 10,  65 => 8,  61 => 7,  53 => 5,  48 => 1,  46 => 4,  44 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/templates/app/dashboard.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/app/dashboard.twig");
    }
}
