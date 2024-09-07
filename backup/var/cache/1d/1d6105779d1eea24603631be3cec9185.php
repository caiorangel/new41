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

/* @theme/sections/header.twig */
class __TwigTemplate_1b024decf726f3149187ee646fd7828b extends Template
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
        yield "<header class=\"flex items-center gap-5 mt-4 sm:py-3 lg:gap-20\">
  <div>
    <a href=\"/\">
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

  <nav class=\"hidden font-medium lg:block\">
    <ul class=\"flex items-center gap-4\">
      <li>
        <a href=\"/#product\"
          class=\"block px-2 py-1 bg-transparent rounded-lg hover:bg-line-tertiary hover:no-underline\">
          ";
        // line 19
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Product"), "html", null, true);
        yield "
        </a>
      </li>

      <li>
        <a href=\"/#features\"
          class=\"block px-2 py-1 bg-transparent rounded-lg hover:bg-line-tertiary hover:no-underline\">
          ";
        // line 26
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Featured"), "html", null, true);
        yield "
        </a>
      </li>

      <li>
        <a href=\"/#pricing\"
          class=\"block px-2 py-1 bg-transparent rounded-lg hover:bg-line-tertiary hover:no-underline\">
          ";
        // line 33
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Pricing"), "html", null, true);
        yield "
        </a>
      </li>
    </ul>
  </nav>

  <div class=\"flex items-center gap-2 ml-auto sm:gap-4\">
    ";
        // line 40
        if (( !CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 40), "modes", [], "any", true, true, false, 40) || (Twig\Extension\CoreExtension::lengthFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, false, false, 40), "modes", [], "any", false, false, false, 40)) > 1))) {
            // line 41
            yield "    <mode-switcher>
      <button
        class=\"flex items-center justify-center w-10 h-10 text-2xl rounded-full bg-line-tertiary hover:bg-contrast-accent hover:text-accent\"
        aria-label=\"Dark/Light mode toggle\">
        <i class=\"ti ti-moon group-data-[mode=dark]/html:hidden\"></i>
        <i class=\"ti ti-sun hidden group-data-[mode=dark]/html:block\"></i>
      </button>
    </mode-switcher>
    ";
        }
        // line 50
        yield "
    ";
        // line 51
        if (array_key_exists("user", $context)) {
            // line 52
            yield "    <div class=\"relative flex items-center group\" x-ref=\"usermenu\"
      @click.outside=\"\$el.removeAttribute('data-open')\">

      <div
        class=\"w-0 h-6 border-l border-l-line-tertiary group-hover:opacity-0 group-data-[open]:opacity-0\">
      </div>

      <button
        class=\"flex items-center gap-2 px-4 py-2 rounded-lg hover:bg-contrast-secondary group-data-[open]:bg-contrast-secondary\"
        @click=\"\$refs.usermenu.hasAttribute('data-open') ? \$refs.usermenu.removeAttribute('data-open') : \$refs.usermenu.setAttribute('data-open', '')\">

        ";
            // line 63
            $context["full_name"] = ((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 63) . " ") . CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 63));
            // line 64
            yield "        <div
          class=\"relative flex items-center justify-center w-10 h-10 text-xs font-bold uppercase rounded-full bg-contrast-accent text-accent shrink-0\">
          <span
            x-text=\"`";
            // line 67
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["full_name"] ?? null), "html", null, true);
            yield "`.match(/(\\b\\S)?/g).join('').slice(0, 2)\">";
            yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::slice($this->env, ($context["full_name"] ?? null), 0, 2), "html", null, true);
            yield "</span>

          ";
            // line 69
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 69)) {
                // line 70
                yield "          <img src=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 70), "html", null, true);
                yield "\" alt=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, ($context["full_name"] ?? null), "html", null, true);
                yield "\"
            class=\"absolute top-0 left-0 object-cover w-full h-full rounded-full\">
          ";
            }
            // line 73
            yield "        </div>

        <span class=\"hidden text-sm sm:inline\">
          ";
            // line 76
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["full_name"] ?? null), "html", null, true);
            yield "
        </span>

        <i class=\"text-xl ti ti-chevron-down\"></i>
      </button>

      <div class=\"context-menu w-60 max-h-max\"
        @click=\"\$refs.usermenu.removeAttribute('data-open')\">

        <a href=\"/app/account\"
          class=\"flex items-center w-full gap-3 p-4 text-left hover:bg-contrast-secondary hover:no-underline\">
          <div
            class=\"relative flex items-center justify-center w-10 h-10 text-xs font-bold uppercase rounded-full bg-contrast-accent text-accent shrink-0\">
            <span
              x-text=\"`";
            // line 90
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["full_name"] ?? null), "html", null, true);
            yield "`.match(/(\\b\\S)?/g).join('').slice(0, 2)\">";
            yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::slice($this->env, ($context["full_name"] ?? null), 0, 2), "html", null, true);
            yield "</span>

            ";
            // line 92
            if (CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 92)) {
                // line 93
                yield "            <img src=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "avatar", [], "any", false, false, false, 93), "html", null, true);
                yield "\" alt=\"";
                yield Twig\Extension\EscaperExtension::escape($this->env, ($context["full_name"] ?? null), "html", null, true);
                yield "\"
              class=\"absolute top-0 left-0 object-cover w-full h-full rounded-full\">
            ";
            }
            // line 96
            yield "          </div>

          <div class=\"max-w-[154px]\">
            <div class=\"font-bold truncate\">";
            // line 99
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["full_name"] ?? null), "html", null, true);
            yield "</div>
            <div class=\"mt-1 text-sm truncate text-tertiary\">
              ";
            // line 101
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "email", [], "any", false, false, false, 101), "html", null, true);
            yield "</div>
          </div>
        </a>

        <hr class=\"border-t border-line-tertiary\">
        <ul>
          <li>
            <a href=\"/app\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-contrast-secondary hover:no-underline\">
              <i class=\"text-2xl ti ti-sparkles\"></i>
              ";
            // line 111
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Go to app"), "html", null, true);
            yield "
            </a>
          </li>
        </ul>

        <hr class=\"border-t border-line-tertiary\">

        <ul>
          <li>
            <a href=\"/app/library\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-contrast-secondary hover:no-underline\">
              <i class=\"text-2xl ti ti-files\"></i>
              ";
            // line 123
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Library"), "html", null, true);
            yield "
            </a>
          </li>

          <li>
            <a href=\"/app/billing\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-contrast-secondary hover:no-underline\">
              <i class=\"text-2xl ti ti-credit-card\"></i>
              ";
            // line 131
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Billing"), "html", null, true);
            yield "
            </a>
          </li>
        </ul>

        <hr class=\"border-t border-line-tertiary\">

        <ul>
          <li>
            <a href=\"/app/account\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-contrast-secondary hover:no-underline\">
              <i class=\"text-2xl ti ti-user-circle\"></i>
              ";
            // line 143
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Account"), "html", null, true);
            yield "
            </a>
          </li>

          <li>
            <a href=\"/logout\"
              class=\"flex items-center gap-2 px-4 py-2 hover:bg-contrast-secondary hover:no-underline\">
              <i class=\"text-2xl ti ti-logout\"></i>
              ";
            // line 151
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Logout"), "html", null, true);
            yield "
            </a>
          </li>
        </ul>
      </div>
    </div>
    ";
        } else {
            // line 158
            yield "    <div class=\"relative flex items-center group\" x-ref=\"locale\"
      @click.outside=\"\$el.removeAttribute('data-open')\">

      <button
        class=\"flex items-center justify-center w-10 h-10 text-2xl rounded-full bg-line-tertiary hover:bg-contrast-accent hover:text-accent\"
        @click=\"\$refs.locale.hasAttribute('data-open') ? \$refs.locale.removeAttribute('data-open') : \$refs.locale.setAttribute('data-open', '')\"
        aria-label=\"Language selector\">
        <i class=\"ti ti-world\"></i>
      </button>

      <div class=\"w-auto translate-x-1/2 context-menu max-h-max right-1/2\"
        @click=\"\$refs.locale.removeAttribute('data-open')\">

        <ul>
          ";
            // line 172
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["locales"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["locale"]) {
                // line 173
                yield "          ";
                if (CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "enabled", [], "any", false, false, false, 173)) {
                    // line 174
                    yield "          <li>
            <a href=\"/";
                    // line 175
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "name", [], "any", false, false, false, 175), "html", null, true);
                    yield "\"
              class=\"block w-full px-4 py-2 text-left hover:bg-contrast-secondary hover:no-underline\"
              @click=\"document.cookie = `locale=";
                    // line 177
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "name", [], "any", false, false, false, 177), "html", null, true);
                    yield "; expires=\${new Date(new Date().getTime()+1000*60*60*24*365).toGMTString()}; path=/`;\">
              ";
                    // line 178
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["locale"], "label", [], "any", false, false, false, 178), "html", null, true);
                    yield "
            </a>
          </li>
          ";
                }
                // line 182
                yield "          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['locale'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 183
            yield "        </ul>
      </div>
    </div>

    <div class=\"w-0 h-6 border-l border-l-line-tertiary\"></div>

    <a href=\"/login\"
      class=\"hidden button button-outline button-sm sm:inline-flex\">
      ";
            // line 191
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Login"), "html", null, true);
            yield "
    </a>

    <a href=\"/signup\"
      class=\"h-8 px-2 text-sm button button-sm whitespace-nowrap sm:text-base sm:h-10 sm:px-4\">
      ";
            // line 196
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Get started"), "html", null, true);
            yield "
    </a>
    ";
        }
        // line 199
        yield "  </div>
</header>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/header.twig";
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
        return array (  353 => 199,  347 => 196,  339 => 191,  329 => 183,  323 => 182,  316 => 178,  312 => 177,  307 => 175,  304 => 174,  301 => 173,  297 => 172,  281 => 158,  271 => 151,  260 => 143,  245 => 131,  234 => 123,  219 => 111,  206 => 101,  201 => 99,  196 => 96,  187 => 93,  185 => 92,  178 => 90,  161 => 76,  156 => 73,  147 => 70,  145 => 69,  138 => 67,  133 => 64,  131 => 63,  118 => 52,  116 => 51,  113 => 50,  102 => 41,  100 => 40,  90 => 33,  80 => 26,  70 => 19,  57 => 9,  53 => 8,  47 => 5,  43 => 4,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/header.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/header.twig");
    }
}
