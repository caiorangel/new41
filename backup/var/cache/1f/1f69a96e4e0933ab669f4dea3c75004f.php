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

/* @theme/sections/footer.twig */
class __TwigTemplate_f806c12167a3132e47f45a41a65ca717 extends Template
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
        $context["copyright"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 2
            yield "<div class=\"text-sm\">
  &copy; ";
            // line 3
            yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::dateFormatFilter($this->env, "now", "Y"), "html", null, true);
            yield "
  ";
            // line 4
            yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "All rights reserved."), "html", null, true);
            yield "

  ";
            // line 6
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", false, true, false, 6), "name", [], "any", true, true, false, 6) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", false, false, false, 6), "name", [], "any", false, false, false, 6)))) {
                // line 7
                yield "  <strong>";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", false, false, false, 7), "name", [], "any", false, false, false, 7), "html", null, true);
                yield "</strong>
  ";
            } elseif ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,             // line 8
($context["option"] ?? null), "site", [], "any", false, true, false, 8), "name", [], "any", true, true, false, 8) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 8), "name", [], "any", false, false, false, 8)))) {
                // line 9
                yield "  <strong>";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 9), "name", [], "any", false, false, false, 9), "html", null, true);
                yield "</strong>
  ";
            }
            // line 11
            yield "</div>
";
        })() ?? new \EmptyIterator())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 13
        yield "
<footer class=\"mb-10 xl:mb-28 wrapper enter\">
  <div class=\"p-12 bg-contrast-secondary\">
    <div class=\"items-start justify-between gap-20 md:flex\">
      <div>
        <img
          src=\"";
        // line 19
        yield Twig\Extension\EscaperExtension::escape($this->env, (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 19), "alternative_logo_dark", [], "any", true, true, false, 19) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 19), "alternative_logo_dark", [], "any", false, false, false, 19)))) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 19), "alternative_logo_dark", [], "any", false, false, false, 19)) : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 19), "logo_dark", [], "any", true, true, false, 19) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 19), "logo_dark", [], "any", false, false, false, 19)))) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 19), "logo_dark", [], "any", false, false, false, 19)) : ("/assets/logo-light.svg")))), "html", null, true);
        yield "\"
          alt=\"";
        // line 20
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 20), "name", [], "any", true, true, false, 20) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 20), "name", [], "any", false, false, false, 20)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 20), "name", [], "any", false, false, false, 20), "html", null, true)) : (yield "Logo"));
        yield "\"
          class=\"hidden group-data-[mode=dark]/html:block max-w-[140px]\">

        <img
          src=\"";
        // line 24
        yield Twig\Extension\EscaperExtension::escape($this->env, (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 24), "alternative_logo", [], "any", true, true, false, 24) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 24), "alternative_logo", [], "any", false, false, false, 24)))) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 24), "alternative_logo", [], "any", false, false, false, 24)) : ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 24), "logo", [], "any", true, true, false, 24) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 24), "logo", [], "any", false, false, false, 24)))) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 24), "logo", [], "any", false, false, false, 24)) : ("/assets/logo-dark.svg")))), "html", null, true);
        yield "\"
          alt=\"";
        // line 25
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 25), "name", [], "any", true, true, false, 25) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 25), "name", [], "any", false, false, false, 25)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 25), "name", [], "any", false, false, false, 25), "html", null, true)) : (yield "Logo"));
        yield "\"
          class=\"block group-data-[mode=dark]/html:hidden  max-w-[140px]\">

        <div class=\"mt-6\">
          ";
        // line 29
        if (( !CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", true, true, false, 29) &&  !CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "links", [], "any", true, true, false, 29))) {
            // line 30
            yield "          ";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["copyright"] ?? null), "html", null, true);
            yield "
          ";
        } elseif ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source,         // line 31
($context["option"] ?? null), "business", [], "any", false, true, false, 31), "address", [], "any", true, true, false, 31) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", false, false, false, 31), "address", [], "any", false, false, false, 31)))) {
            // line 32
            yield "          <address class=\"not-italic\">
            ";
            // line 33
            yield Twig\Extension\CoreExtension::nl2br(Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", false, false, false, 33), "address", [], "any", false, false, false, 33), "html", null, true));
            yield "
          </address>
          ";
        }
        // line 36
        yield "        </div>
      </div>

      <nav class=\"flex items-start gap-20 mt-6 font-bold md:mt-0\">
        <ul class=\"flex flex-col gap-4\">
          <li>
            <a href=\"/#product\">";
        // line 42
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Product"), "html", null, true);
        yield "</a>
          </li>

          <li>
            <a href=\"/#pricing\">";
        // line 46
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Pricing"), "html", null, true);
        yield "</a>
          </li>

          <li>
            <a href=\"/#faq\">";
        // line 50
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "FAQ"), "html", null, true);
        yield "</a>
          </li>
        </ul>

        <ul class=\"flex flex-col gap-4\">
          ";
        // line 55
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, true, false, 55), "tos", [], "any", true, true, false, 55) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, false, false, 55), "tos", [], "any", false, false, false, 55)))) {
            // line 56
            yield "          <li><a href=\"/policies/terms\">
              ";
            // line 57
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Terms of services"), "html", null, true);
            yield "
            </a></li>
          ";
        }
        // line 60
        yield "
          ";
        // line 61
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, true, false, 61), "privacy", [], "any", true, true, false, 61) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, false, false, 61), "privacy", [], "any", false, false, false, 61)))) {
            // line 62
            yield "          <li><a href=\"/policies/privacy\">
              ";
            // line 63
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Privacy policy"), "html", null, true);
            yield "
            </a></li>
          ";
        }
        // line 66
        yield "
          ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, true, false, 67), "refund", [], "any", true, true, false, 67) &&  !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "policies", [], "any", false, false, false, 67), "refund", [], "any", false, false, false, 67)))) {
            // line 68
            yield "          <li><a href=\"/policies/refund\">
              ";
            // line 69
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Refund policy"), "html", null, true);
            yield "
            </a></li>
          ";
        }
        // line 72
        yield "        </ul>
      </nav>
    </div>

    ";
        // line 76
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "business", [], "any", true, true, false, 76) || CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "links", [], "any", true, true, false, 76))) {
            // line 77
            yield "    <div
      class=\"items-center justify-between gap-20 mt-12 md:flex text-secondary\">
      ";
            // line 79
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["copyright"] ?? null), "html", null, true);
            yield "

      <ul class=\"flex items-center gap-4 mt-6 md:mt-0\">
        ";
            // line 82
            $context["links"] = ["x", "facebook", "instagram", "tiktok", "discord", "linkedin", "youtube", "github", "telegram", "vk"];
            // line 83
            yield "
        ";
            // line 84
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["links"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
                // line 85
                yield "        ";
                if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "links", [], "any", false, true, false, 85), $context["link"], [], "array", true, true, false, 85) &&  !Twig\Extension\CoreExtension::testEmpty((($__internal_compile_0 = CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "links", [], "any", false, false, false, 85)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[$context["link"]] ?? null) : null)))) {
                    // line 86
                    yield "        <li>
          <a href=\"";
                    // line 87
                    yield Twig\Extension\EscaperExtension::escape($this->env, (($__internal_compile_1 = CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "links", [], "any", false, false, false, 87)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[$context["link"]] ?? null) : null), "html_attr");
                    yield "\" target=\"_blank\"
            class=\"transition-all hover:no-underline hover:text-primary\"
            aria-label=\"";
                    // line 89
                    yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::capitalizeStringFilter($this->env, $context["link"]), "html", null, true);
                    yield "\">
            <i class=\"text-lg ti ti-brand-";
                    // line 90
                    yield Twig\Extension\EscaperExtension::escape($this->env, $context["link"], "html", null, true);
                    yield "\"></i>
          </a>
        </li>
        ";
                }
                // line 94
                yield "        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            yield "      </ul>
    </div>
    ";
        }
        // line 98
        yield "  </div>
</footer>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/footer.twig";
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
        return array (  248 => 98,  243 => 95,  237 => 94,  230 => 90,  226 => 89,  221 => 87,  218 => 86,  215 => 85,  211 => 84,  208 => 83,  206 => 82,  200 => 79,  196 => 77,  194 => 76,  188 => 72,  182 => 69,  179 => 68,  177 => 67,  174 => 66,  168 => 63,  165 => 62,  163 => 61,  160 => 60,  154 => 57,  151 => 56,  149 => 55,  141 => 50,  134 => 46,  127 => 42,  119 => 36,  113 => 33,  110 => 32,  108 => 31,  103 => 30,  101 => 29,  94 => 25,  90 => 24,  83 => 20,  79 => 19,  71 => 13,  67 => 11,  61 => 9,  59 => 8,  54 => 7,  52 => 6,  47 => 4,  43 => 3,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/footer.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/footer.twig");
    }
}
