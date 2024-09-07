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

/* /templates/auth/signup.twig */
class __TwigTemplate_95d1980587d0d9cb54b7ee9bf2f144c6 extends Template
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
        $this->parent = $this->loadTemplate("/layouts/minimal.twig", "/templates/auth/signup.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Signup")), "html", null, true);
        return; yield '';
    }

    // line 6
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 7
        yield "<div class=\"box\" data-density=\"comfortable\">
  <x-form>
    <form @submit.prevent=\"submit\" x-ref=\"form\" data-api-path=\"/signup\"
      class=\"flex flex-col gap-5\">
      <h1>";
        // line 11
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Sign up"), "html", null, true);
        yield "</h1>

      <div class=\"grid gap-6 md:grid-cols-2\">
        <fieldset>
          <label for=\"first-name\">";
        // line 15
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "First name"), "html", null, true);
        yield "</label>

          <input type=\"text\" id=\"first-name\" name=\"first_name\"
            placeholder=\"";
        // line 18
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Type your first name"), "html", null, true);
        yield "\"
            autocomplete=\"given-name\" class=\"input\" required>
        </fieldset>

        <fieldset>
          <label for=\"last-name\">";
        // line 23
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Last name"), "html", null, true);
        yield "</label>

          <input type=\"text\" id=\"last-name\" name=\"last_name\"
            autocomplete=\"family-name\" required
            placeholder=\"";
        // line 27
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Type your last name"), "html", null, true);
        yield "\" class=\"input\">
        </fieldset>
      </div>

      <fieldset>
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

      <fieldset>
        <label for=\"password\">";
        // line 40
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Password"), "html", null, true);
        yield "</label>

        <div class=\"relative\" x-data=\"{isVisible: false}\">
          <input :type=\"isVisible ? 'text' : 'password'\" id=\"password\"
            name=\"password\" placeholder=\"";
        // line 44
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

      ";
        // line 56
        yield from         $this->loadTemplate("/snippets/captcha.twig", "/templates/auth/signup.twig", 56)->unwrap()->yield($context);
        // line 57
        yield "
      <button type=\"submit\" class=\"w-full button button-accent\"
        :processing=\"isProcessing\">

        ";
        // line 61
        yield from         $this->loadTemplate("/snippets/spinner.twig", "/templates/auth/signup.twig", 61)->unwrap()->yield($context);
        // line 62
        yield "
        ";
        // line 63
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Sign up"), "html", null, true);
        yield "
      </button>

      <div class=\"flex flex-col items-center gap-1 text-sm md:flex-row\">
        <span class=\"flex items-center gap-1\">
          <i class=\"text-base ti ti-help-square-rounded\"></i>

          ";
        // line 70
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Already have an account?"), "html", null, true);
        yield "
        </span>

        <a href=\"login\" class=\"font-semibold hover:underline\">
          ";
        // line 74
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Sign in"), "html", null, true);
        yield "
        </a>
      </div>

      ";
        // line 78
        yield from         $this->loadTemplate("/snippets/sso.twig", "/templates/auth/signup.twig", 78)->unwrap()->yield($context);
        // line 79
        yield "
      ";
        // line 80
        $context["policies"] = [];
        // line 81
        yield "      ";
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, true, false, 81), "tos", [], "any", true, true, false, 81) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, false, false, 81), "tos", [], "any", false, false, false, 81)))) {
            // line 82
            yield "      ";
            $context["policy"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                // line 83
                yield "      <a href=\"policies/terms\"
        class=\"text-content hover:text-content hover:underline\">";
                // line 84
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Terms"), "html", null, true);
                yield "</a>
      ";
            })() ?? new \EmptyIterator())) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 86
            yield "
      ";
            // line 87
            $context["policies"] = Twig\Extension\CoreExtension::arrayMerge(($context["policies"] ?? null), [($context["policy"] ?? null)]);
            // line 88
            yield "      ";
        }
        // line 89
        yield "
      ";
        // line 90
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, true, false, 90), "privacy", [], "any", true, true, false, 90) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, false, false, 90), "privacy", [], "any", false, false, false, 90)))) {
            // line 91
            yield "      ";
            $context["policy"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                // line 92
                yield "      <a href=\"policies/privacy\"
        class=\"text-content hover:text-content hover:underline\">";
                // line 93
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Privacy Policy"), "html", null, true);
                yield "</a>
      ";
            })() ?? new \EmptyIterator())) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 95
            yield "
      ";
            // line 96
            $context["policies"] = Twig\Extension\CoreExtension::arrayMerge(($context["policies"] ?? null), [($context["policy"] ?? null)]);
            // line 97
            yield "      ";
        }
        // line 98
        yield "
      ";
        // line 99
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, true, false, 99), "refund", [], "any", true, true, false, 99) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, false, false, 99), "refund", [], "any", false, false, false, 99)))) {
            // line 100
            yield "      ";
            $context["policy"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
                // line 101
                yield "      <a href=\"policies/refund\"
        class=\"text-content hover:text-content hover:underline\">
        ";
                // line 103
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Refund Policy"), "html", null, true);
                yield "
      </a>
      ";
            })() ?? new \EmptyIterator())) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 106
            yield "
      ";
            // line 107
            $context["policies"] = Twig\Extension\CoreExtension::arrayMerge(($context["policies"] ?? null), [($context["policy"] ?? null)]);
            // line 108
            yield "      ";
        }
        // line 109
        yield "
      ";
        // line 110
        if ((Twig\Extension\CoreExtension::lengthFilter($this->env, ($context["policies"] ?? null)) > 0)) {
            // line 111
            yield "      <div class=\"text-xs text-content-dimmed\">
        ";
            // line 112
            yield __("By signing up, you agree to our %s", Twig\Extension\CoreExtension::joinFilter(($context["policies"] ?? null), ", ", __(" and ")));
            yield "
      </div>
      ";
        }
        // line 115
        yield "    </form>
  </x-form>
</div>
";
        return; yield '';
    }

    // line 120
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 121
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
        return "/templates/auth/signup.twig";
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
        return array (  284 => 121,  280 => 120,  272 => 115,  266 => 112,  263 => 111,  261 => 110,  258 => 109,  255 => 108,  253 => 107,  250 => 106,  244 => 103,  240 => 101,  237 => 100,  235 => 99,  232 => 98,  229 => 97,  227 => 96,  224 => 95,  219 => 93,  216 => 92,  213 => 91,  211 => 90,  208 => 89,  205 => 88,  203 => 87,  200 => 86,  195 => 84,  192 => 83,  189 => 82,  186 => 81,  184 => 80,  181 => 79,  179 => 78,  172 => 74,  165 => 70,  155 => 63,  152 => 62,  150 => 61,  144 => 57,  142 => 56,  127 => 44,  120 => 40,  112 => 35,  106 => 32,  98 => 27,  91 => 23,  83 => 18,  77 => 15,  70 => 11,  64 => 7,  60 => 6,  52 => 3,  47 => 1,  45 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/templates/auth/signup.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/auth/signup.twig");
    }
}
