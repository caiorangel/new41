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

/* /templates/auth/recovery.twig */
class __TwigTemplate_f0b4eb6eb758bbb51ddf096c49328489 extends Template
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
        // line 4
        $context["xdata"] = "auth";
        // line 1
        $this->parent = $this->loadTemplate("/layouts/minimal.twig", "/templates/auth/recovery.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Password recovery")), "html", null, true);
        return; yield '';
    }

    // line 6
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        yield "<div class=\"box\" data-density=\"comfortable\">
  <x-form>
    <form @submit.prevent=\"submit\" x-ref=\"form\" data-api-path=\"/recovery\"
      class=\"flex flex-col gap-5\">
      <div class=\"flex flex-col gap-2\">
        ";
        // line 12
        yield from         $this->loadTemplate("snippets/back.twig", "/templates/auth/recovery.twig", 12)->unwrap()->yield(CoreExtension::arrayMerge($context, ["link" => "login", "label" => p__("button", "Back to login")]));
        // line 13
        yield "
        <h1>
          <span :class=\"{'hidden':success}\">
            ";
        // line 16
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Password recovery"), "html", null, true);
        yield "
          </span>

          <template x-if=\"success\">
            <span>";
        // line 20
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Check your email!"), "html", null, true);
        yield "</span>
          </template>
        </h1>
      </div>

      <template x-if=\"success\">
        <p class=\"text-content-dimmed\">
          ";
        // line 27
        yield Twig\Extension\EscaperExtension::escape($this->env, __("We send password reset instruction to your email address. Please check your inbox and follow the instructions."), "html", null, true);
        yield "
        </p>
      </template>

      <fieldset :class=\"{'hidden':success}\">
        <label for=\"email\">";
        // line 32
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Email"), "html", null, true);
        yield "</label>

        <input type=\"email\" id=\"email\" name=\"email\"
          placeholder=\"";
        // line 35
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Type your email address"), "html", null, true);
        yield "\" autocomplete=\"email\"
          class=\"input\" required>
      </fieldset>

      <template x-if=\"!success\">
        ";
        // line 40
        yield from         $this->loadTemplate("/snippets/captcha.twig", "/templates/auth/recovery.twig", 40)->unwrap()->yield($context);
        // line 41
        yield "      </template>

      <button type=\"submit\" class=\"w-full button button-accent\"
        :class=\"{'hidden':success}\" :processing=\"isProcessing\">
        ";
        // line 45
        yield from         $this->loadTemplate("/snippets/spinner.twig", "/templates/auth/recovery.twig", 45)->unwrap()->yield($context);
        // line 46
        yield "
        ";
        // line 47
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Send request"), "html", null, true);
        yield "
      </button>

      ";
        // line 50
        $context["user_accounts_enabled"] = ( !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 50), "user_accounts_enabled", [], "any", true, true, false, 50) || CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 50), "user_accounts_enabled", [], "any", false, false, false, 50));
        // line 51
        yield "      ";
        $context["user_signup_enabled"] = ( !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 51), "user_signup_enabled", [], "any", true, true, false, 51) || CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 51), "user_signup_enabled", [], "any", false, false, false, 51));
        // line 52
        yield "
      ";
        // line 53
        if ((($context["user_accounts_enabled"] ?? null) && ($context["user_signup_enabled"] ?? null))) {
            // line 54
            yield "      <div class=\"flex flex-col items-center gap-1 text-sm md:flex-row\">
        <span class=\"flex items-center gap-1\">
          <i class=\"text-base ti ti-help-square-rounded\"></i>

          ";
            // line 58
            yield Twig\Extension\EscaperExtension::escape($this->env, __("Don't have an account?"), "html", null, true);
            yield "
        </span>

        <a href=\"signup\" class=\"font-semibold hover:underline\">
          ";
            // line 62
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Sign up"), "html", null, true);
            yield "
        </a>
      </div>
      ";
        }
        // line 66
        yield "    </form>
  </x-form>
</div>
";
        return; yield '';
    }

    // line 71
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 72
        yield "<script src=\"assets/auth.js?v=";
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
        return "/templates/auth/recovery.twig";
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
        return array (  178 => 72,  174 => 71,  166 => 66,  159 => 62,  152 => 58,  146 => 54,  144 => 53,  141 => 52,  138 => 51,  136 => 50,  130 => 47,  127 => 46,  125 => 45,  119 => 41,  117 => 40,  109 => 35,  103 => 32,  95 => 27,  85 => 20,  78 => 16,  73 => 13,  71 => 12,  64 => 7,  60 => 6,  52 => 3,  47 => 1,  45 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/templates/auth/recovery.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/auth/recovery.twig");
    }
}
