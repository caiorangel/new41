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

/* sections/header.twig */
class __TwigTemplate_d71777c3b333cebf7377b4fcb76d4a8b extends Template
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
        yield "<header class=\"flex items-center justify-between py-4 md:py-6\">
  <div>
    <a href=\"app\">
      <img src=\"";
        // line 4
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 4), "logo_dark", [], "any", true, true, false, 4) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 4), "logo_dark", [], "any", false, false, false, 4)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 4), "logo_dark", [], "any", false, false, false, 4), "html", null, true)) : (yield "/assets/logo-light.svg"));
        yield "\"
        alt=\"";
        // line 5
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 5), "name", [], "any", true, true, false, 5) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 5), "name", [], "any", false, false, false, 5)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 5), "name", [], "any", false, false, false, 5), "html", null, true)) : (yield "Logo"));
        yield "\"
        class=\"hidden group-data-[mode=dark]/html:block max-w-[140px]\">

      <img src=\"";
        // line 8
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 8), "logo", [], "any", true, true, false, 8) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 8), "logo", [], "any", false, false, false, 8)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 8), "logo", [], "any", false, false, false, 8), "html", null, true)) : (yield "/assets/logo-dark.svg"));
        yield "\"
        alt=\"";
        // line 9
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 9), "name", [], "any", true, true, false, 9) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 9), "name", [], "any", false, false, false, 9)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 9), "name", [], "any", false, false, false, 9), "html", null, true)) : (yield "Logo"));
        yield "\"
        class=\"block group-data-[mode=dark]/html:hidden  max-w-[140px]\">
    </a>
  </div>

  <div class=\"flex items-center gap-2\">
    ";
        // line 15
        if (( !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 15), "modes", [], "any", true, true, false, 15) || (Twig\Extension\CoreExtension::lengthFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, false, false, 15), "modes", [], "any", false, false, false, 15)) > 1))) {
            // line 16
            yield "    <mode-switcher>
      <button
        class=\"flex items-center justify-center w-10 h-10 text-2xl rounded-full bg-intermediate hover:bg-accent hover:text-accent-content\">
        <i class=\"ti ti-moon group-data-[mode=dark]/html:hidden\"></i>
        <i class=\"ti ti-sun hidden group-data-[mode=dark]/html:block\"></i>
      </button>
    </mode-switcher>
    ";
        }
        // line 24
        yield "
    ";
        // line 25
        if (array_key_exists("user", $context)) {
            // line 26
            yield "    <div class=\"relative flex items-center group\"
      @click.outside=\"\$refs.usermenu.removeAttribute('data-open')\">

      <div
        class=\"w-0 h-6 border-l border-l-line-dimmed group-hover:opacity-0 group-data-[open]:opacity-0\">
      </div>

      <button
        class=\"flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-intermediate group-data-[open]:bg-intermediate\"
        @click=\"\$refs.usermenu.toggleAttribute('data-open')\">

        <div class=\"avatar bg-accent text-accent-content\">
          <span>";
            // line 38
            yield Twig\Extension\EscaperExtension::escape($this->env, (Twig\Extension\CoreExtension::slice($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 38), 0, 1) . Twig\Extension\CoreExtension::slice($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 38), 0, 1)), "html", null, true);
            yield "</span>

          ";
            // line 40
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 40)) {
                // line 41
                yield "          <img src=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 41), "html", null, true);
                yield "\"
            alt=\"";
                // line 42
                yield Twig\Extension\EscaperExtension::escape($this->env, ((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 42) . " ") . CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 42)), "html", null, true);
                yield "\"
            class=\"absolute top-0 left-0 object-cover w-full h-full rounded-full\">
          ";
            }
            // line 45
            yield "        </div>

        <i class=\"text-xl ti ti-chevron-down\"></i>
      </button>

      <div class=\"menu w-60\" @click=\"\$el.removeAttribute('data-open')\"
        x-ref=\"usermenu\">

        <a href=\"app/account\"
          class=\"flex items-center w-full gap-3 p-4 text-left hover:bg-intermediate hover:no-underline\">
          <div class=\"avatar bg-accent text-accent-content\">
            <span>";
            // line 56
            yield Twig\Extension\EscaperExtension::escape($this->env, (Twig\Extension\CoreExtension::slice($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 56), 0, 1) . Twig\Extension\CoreExtension::slice($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 56), 0, 1)), "html", null, true);
            yield "</span>

            ";
            // line 58
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 58)) {
                // line 59
                yield "            <img src=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 59), "html", null, true);
                yield "\"
              alt=\"";
                // line 60
                yield Twig\Extension\EscaperExtension::escape($this->env, ((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 60) . " ") . CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 60)), "html", null, true);
                yield "\"
              class=\"absolute top-0 left-0 object-cover w-full h-full rounded-full\">
            ";
            }
            // line 63
            yield "          </div>

          <div class=\"max-w-[156px]\">
            <div class=\"overflow-hidden font-bold text-ellipsis\">
              ";
            // line 67
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 67), "html", null, true);
            yield "
              ";
            // line 68
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 68), "html", null, true);
            yield "
            </div>

            <div
              class=\"mt-1 overflow-hidden text-sm text-content-dimmed text-ellipsis\">
              ";
            // line 73
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "email", [], "any", false, false, false, 73), "html", null, true);
            yield "</div>
          </div>
        </a>

        ";
            // line 77
            if ((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "role", [], "any", false, false, false, 77) == "admin")) {
                // line 78
                yield "        <hr class=\"border-t border-line-dimmed\">
        <ul>
          ";
                // line 80
                if ((($context["view_namespace"] ?? null) == "admin")) {
                    // line 81
                    yield "          <li>
            <a href=\"app\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-intermediate hover:no-underline\">
              <i class=\"text-2xl ti ti-sparkles\"></i>
              ";
                    // line 85
                    yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Switch to app"), "html", null, true);
                    yield "
            </a>
          </li>
          ";
                } else {
                    // line 89
                    yield "          <li>
            <a href=\"admin/presets\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-intermediate hover:no-underline\">
              <i class=\"text-2xl ti ti-lock-cog\"></i>
              ";
                    // line 93
                    yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Switch to admin"), "html", null, true);
                    yield "
            </a>
          </li>
          ";
                }
                // line 97
                yield "        </ul>
        ";
            }
            // line 99
            yield "
        ";
            // line 100
            if ((($context["view_namespace"] ?? null) == "app")) {
                // line 101
                yield "        <hr class=\"border-t border-line-dimmed\">

        <ul>
          <li>
            <a href=\"app/documents\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-intermediate hover:no-underline\">
              <i class=\"text-2xl ti ti-files\"></i>
              ";
                // line 108
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Documents"), "html", null, true);
                yield "
            </a>
          </li>

          <li>
            <a href=\"app/billing\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-intermediate hover:no-underline\">
              <i class=\"text-2xl ti ti-credit-card\"></i>
              ";
                // line 116
                yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Billing"), "html", null, true);
                yield "
            </a>
          </li>
        </ul>
        ";
            }
            // line 121
            yield "
        <hr class=\"border-t border-line-dimmed\">

        <ul>
          <li>
            <a href=\"app/account\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-intermediate hover:no-underline\">
              <i class=\"text-2xl ti ti-user-circle\"></i>
              ";
            // line 129
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Account"), "html", null, true);
            yield "
            </a>
          </li>

          <li>
            <a href=\"logout\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-intermediate hover:no-underline\">
              <i class=\"text-2xl ti ti-logout\"></i>
              ";
            // line 137
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Logout"), "html", null, true);
            yield "
            </a>
          </li>
        </ul>
      </div>
    </div>
    ";
        } else {
            // line 144
            yield "    <div class=\"relative flex items-center group\"
      @click.outside=\"\$refs.locale.removeAttribute('data-open')\">

      <button
        class=\"flex items-center justify-center w-10 h-10 text-2xl rounded-full bg-intermediate hover:bg-accent hover:text-accent-content\"
        @click=\"\$refs.locale.hasAttribute('data-open') ? \$refs.locale.removeAttribute('data-open') : \$refs.locale.setAttribute('data-open', '')\"
        aria-label=\"Language selector\">
        <i class=\"ti ti-world\"></i>
      </button>

      <div class=\"w-auto menu\"
        @click=\"\$refs.locale.removeAttribute('data-open')\" x-ref=\"locale\">

        <ul>
          ";
            // line 158
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["locales"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["locale"]) {
                // line 159
                yield "          ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "enabled", [], "any", false, false, false, 159)) {
                    // line 160
                    yield "          <li>
            <a href=\"/";
                    // line 161
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "name", [], "any", false, false, false, 161), "html", null, true);
                    yield "\"
              class=\"block w-full px-4 py-2 text-left hover:bg-intermediate hover:no-underline\"
              @click.prevent=\"document.cookie = `locale=";
                    // line 163
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "name", [], "any", false, false, false, 163), "html", null, true);
                    yield "; expires=\${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/`; window.location.reload();\">
              ";
                    // line 164
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "label", [], "any", false, false, false, 164), "html", null, true);
                    yield "
            </a>
          </li>
          ";
                }
                // line 168
                yield "          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['locale'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 169
            yield "        </ul>
      </div>
    </div>
    ";
        }
        // line 173
        yield "  </div>
</header>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "sections/header.twig";
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
        return array (  327 => 173,  321 => 169,  315 => 168,  308 => 164,  304 => 163,  299 => 161,  296 => 160,  293 => 159,  289 => 158,  273 => 144,  263 => 137,  252 => 129,  242 => 121,  234 => 116,  223 => 108,  214 => 101,  212 => 100,  209 => 99,  205 => 97,  198 => 93,  192 => 89,  185 => 85,  179 => 81,  177 => 80,  173 => 78,  171 => 77,  164 => 73,  156 => 68,  152 => 67,  146 => 63,  140 => 60,  135 => 59,  133 => 58,  128 => 56,  115 => 45,  109 => 42,  104 => 41,  102 => 40,  97 => 38,  83 => 26,  81 => 25,  78 => 24,  68 => 16,  66 => 15,  57 => 9,  53 => 8,  47 => 5,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "sections/header.twig", "/home/u489518759/domains/renvon.com/resources/views/sections/header.twig");
    }
}
