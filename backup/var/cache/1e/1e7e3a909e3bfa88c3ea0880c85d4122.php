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

/* /templates/auth/login.twig */
class __TwigTemplate_41d2335377ca6917b4fd7d4711a6ff45 extends Template
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
        $this->parent = $this->loadTemplate("/layouts/minimal.twig", "/templates/auth/login.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Login")), "html", null, true);
        return; yield '';
    }

    // line 6
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        yield "<div class=\"flex flex-col gap-1\">
  ";
        // line 8
        if ((($context["environment"] ?? null) == "demo")) {
            // line 9
            yield "  <div class=\"flex flex-col gap-5 box\" data-density=\"comfortable\">
    <div>
      <h1>
        ";
            // line 12
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Demo mode"), "html", null, true);
            yield "
      </h1>

      <p class=\"mt-4\">
        ";
            // line 16
            yield Twig\Extension\EscaperExtension::escape($this->env, __("Demo mode is enabled. Some features might be disabled. All of those features will be available in the purchased version."), "html", null, true);
            yield "
      </p>
    </div>

    ";
            // line 20
            if (( !Twig\Extension\CoreExtension::testEmpty(($context["demo_account_email"] ?? null)) &&  !Twig\Extension\CoreExtension::testEmpty(($context["demo_account_password"] ?? null)))) {
                // line 21
                yield "    <div>
      <p>
        ";
                // line 23
                yield Twig\Extension\EscaperExtension::escape($this->env, __("Use following credentials to login as an admin."), "html", null, true);
                yield "
      </p>

      <div class=\"mt-4 font-mono text-sm\">
        <div>
          <span class=\"font-semibold uppercase\">
            ";
                // line 29
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Email"), "html", null, true);
                yield ":
          </span>
          <x-copy data-tippy-placement=\"right\">";
                // line 31
                yield Twig\Extension\EscaperExtension::escape($this->env, ($context["demo_account_email"] ?? null), "html", null, true);
                yield "</x-copy>
        </div>

        <div class=\"mt-1\">
          <span class=\"font-semibold uppercase\">
            ";
                // line 36
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Password"), "html", null, true);
                yield ":
          </span>
          <x-copy
            data-tippy-placement=\"right\">";
                // line 39
                yield Twig\Extension\EscaperExtension::escape($this->env, ($context["demo_account_password"] ?? null), "html", null, true);
                yield "</x-copy>
        </div>
      </div>
    </div>

    <p class=\"text-xs text-content-dimmed\">
      ";
                // line 45
                yield Twig\Extension\EscaperExtension::escape($this->env, __("You can signup as a new user too to view the app as a normal user."), "html", null, true);
                yield "
    </p>
    ";
            }
            // line 48
            yield "  </div>
  ";
        }
        // line 50
        yield "
  <div class=\"box\" data-density=\"comfortable\">
    <x-form>
      <form @submit.prevent=\"submit\" x-ref=\"form\" data-api-path=\"/basic\"
        class=\"flex flex-col gap-5\">

        <h1>";
        // line 56
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Sign in to your account"), "html", null, true);
        yield "</h1>

        <fieldset>
          <label for=\"email\">";
        // line 59
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Email"), "html", null, true);
        yield "</label>

          <input type=\"email\" id=\"email\" name=\"email\" class=\"input\"
            placeholder=\"";
        // line 62
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Type your email address"), "html", null, true);
        yield "\"
            autocomplete=\"email\" required>
        </fieldset>

        <fieldset>
          <label for=\"password\">";
        // line 67
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Password"), "html", null, true);
        yield "</label>

          <div class=\"relative\" x-data=\"{isVisible: false}\">
            <input :type=\"isVisible ? 'text' : 'password'\" id=\"password\"
              name=\"password\" placeholder=\"";
        // line 71
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Type your password"), "html", null, true);
        yield "\"
              autocomplete=\"current-password\" class=\"input\" required>

            <button type=\"button\"
              class=\"absolute text-2xl -translate-y-1/2 top-1/2 right-3 text-content-dimmed\"
              @click=\"isVisible = !isVisible\">
              <i class=\"block ti\"
                :class=\"{'ti-eye-closed' : isVisible, 'ti-eye':!isVisible}\"></i>
            </button>
          </div>
        </fieldset>

        <div class=\"flex items-center justify-between\">
          <label class=\"inline-flex items-center gap-1\">
            <input type=\"checkbox\" name=\"remember\" class=\"hidden peer\">

            <i
              class=\"ti ti-square-rounded text-content-dimmed peer-checked:hidden\"></i>
            <i
              class=\"hidden ti ti-square-rounded-check-filled text-success peer-checked:block\"></i>

            <span
              class=\"font-normal select-none\">";
        // line 93
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Remember me"), "html", null, true);
        yield "</span>
          </label>

          <a href=\"recovery\"
            class=\"inline-flex items-center gap-1 text-sm font-semibold md:hover:underline\">
            <i class=\"ti ti-lock-question md:hidden\"></i>

            <span class=\"hidden md:inline\">
              ";
        // line 101
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Forgot password?"), "html", null, true);
        yield "
            </span>
          </a>
        </div>

        ";
        // line 106
        yield from         $this->loadTemplate("/snippets/captcha.twig", "/templates/auth/login.twig", 106)->unwrap()->yield($context);
        // line 107
        yield "
        <button type=\"submit\" class=\"w-full button button-accent\"
          :processing=\"isProcessing\">

          ";
        // line 111
        yield from         $this->loadTemplate("/snippets/spinner.twig", "/templates/auth/login.twig", 111)->unwrap()->yield($context);
        // line 112
        yield "
          ";
        // line 113
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Sign in"), "html", null, true);
        yield "
        </button>

        ";
        // line 116
        $context["user_accounts_enabled"] = ( !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 116), "user_accounts_enabled", [], "any", true, true, false, 116) || CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 116), "user_accounts_enabled", [], "any", false, false, false, 116));
        // line 117
        yield "        ";
        $context["user_signup_enabled"] = ( !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 117), "user_signup_enabled", [], "any", true, true, false, 117) || CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 117), "user_signup_enabled", [], "any", false, false, false, 117));
        // line 118
        yield "
        ";
        // line 119
        if ((($context["user_accounts_enabled"] ?? null) && ($context["user_signup_enabled"] ?? null))) {
            // line 120
            yield "        <div class=\"flex flex-col items-center gap-1 text-sm md:flex-row\">
          <span class=\"flex items-center gap-1\">
            <i class=\"text-base ti ti-help-square-rounded\"></i>

            ";
            // line 124
            yield Twig\Extension\EscaperExtension::escape($this->env, __("Don't have an account?"), "html", null, true);
            yield "
          </span>

          <a href=\"signup\" class=\"font-semibold hover:underline\">
            ";
            // line 128
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Sign up"), "html", null, true);
            yield "
          </a>
        </div>
        ";
        }
        // line 132
        yield "
        ";
        // line 133
        yield from         $this->loadTemplate("/snippets/sso.twig", "/templates/auth/login.twig", 133)->unwrap()->yield($context);
        // line 134
        yield "      </form>
    </x-form>
  </div>
</div>
";
        return; yield '';
    }

    // line 140
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 141
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
        return "/templates/auth/login.twig";
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
        return array (  287 => 141,  283 => 140,  274 => 134,  272 => 133,  269 => 132,  262 => 128,  255 => 124,  249 => 120,  247 => 119,  244 => 118,  241 => 117,  239 => 116,  233 => 113,  230 => 112,  228 => 111,  222 => 107,  220 => 106,  212 => 101,  201 => 93,  176 => 71,  169 => 67,  161 => 62,  155 => 59,  149 => 56,  141 => 50,  137 => 48,  131 => 45,  122 => 39,  116 => 36,  108 => 31,  103 => 29,  94 => 23,  90 => 21,  88 => 20,  81 => 16,  74 => 12,  69 => 9,  67 => 8,  64 => 7,  60 => 6,  52 => 3,  47 => 1,  45 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/templates/auth/login.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/auth/login.twig");
    }
}
