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

/* @theme/sections/pricing.twig */
class __TwigTemplate_a79b9fedf7cd9090c08c15114bc4ce36 extends Template
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
        yield "<div x-data=\"pricing\" id=\"pricing\">
  <div class=\"text-center\">
    <h2>";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Pricing"), "html", null, true);
        yield "</h2>

    <p class=\"max-w-md mx-auto mt-6\">
      ";
        // line 6
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Discover the perfect plan to suit your needs and unlock a world of possibilities."), "html", null, true);
        yield "
    </p>
  </div>

  <div class=\"flex justify-center mt-8\">
    <div class=\"rounded-full bg-line-tertiary p-0.5 flex items-center gap-1\"
      x-ref=\"cycles\">
      ";
        // line 13
        if ((Twig\Extension\CoreExtension::lengthFilter($this->env, Twig\Extension\CoreExtension::arrayFilter($this->env, ($context["plans"] ?? null), function ($__p__) use ($context, $macros) { $context["p"] = $__p__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "billing_cycle", [], "any", false, false, false, 13) == "monthly"); })) > 0)) {
            // line 14
            yield "      <button type=\"button\" class=\"px-6 py-3 text-sm font-medium rounded-full\"
        data-cycle=\"monthly\" :class=\"{
          'bg-contrast-primary': cycle=='monthly',
          'shadow': cycle=='monthly'
        }\"
        @click=\"cycle='monthly'\">";
            // line 19
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Monthly"), "html", null, true);
            yield "</button>
      ";
        }
        // line 21
        yield "
      ";
        // line 22
        if ((Twig\Extension\CoreExtension::lengthFilter($this->env, Twig\Extension\CoreExtension::arrayFilter($this->env, ($context["plans"] ?? null), function ($__p__) use ($context, $macros) { $context["p"] = $__p__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "billing_cycle", [], "any", false, false, false, 22) == "yearly"); })) > 0)) {
            // line 23
            yield "      <button type=\"button\" class=\"px-6 py-3 text-sm font-medium rounded-full\"
        data-cycle=\"yearly\" :class=\"{
          'bg-contrast-primary': cycle=='yearly',
          'shadow': cycle=='yearly'
        }\"
        @click=\"cycle='yearly'\">";
            // line 28
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Yearly"), "html", null, true);
            yield "</button>
      ";
        }
        // line 30
        yield "
      ";
        // line 31
        if ((Twig\Extension\CoreExtension::lengthFilter($this->env, Twig\Extension\CoreExtension::arrayFilter($this->env, ($context["plans"] ?? null), function ($__p__) use ($context, $macros) { $context["p"] = $__p__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "billing_cycle", [], "any", false, false, false, 31) == "one-time"); })) > 0)) {
            // line 32
            yield "      <button type=\"button\" class=\"px-6 py-3 text-sm font-medium rounded-full\"
        data-cycle=\"one-time\" :class=\"{
          'bg-contrast-primary': cycle=='one-time',
          'shadow': cycle=='one-time'
        }\"
        @click=\"cycle='one-time'\">";
            // line 37
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Packs"), "html", null, true);
            yield "</button>
      ";
        }
        // line 39
        yield "
      ";
        // line 40
        if ((Twig\Extension\CoreExtension::lengthFilter($this->env, Twig\Extension\CoreExtension::arrayFilter($this->env, ($context["plans"] ?? null), function ($__p__) use ($context, $macros) { $context["p"] = $__p__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["p"] ?? null), "billing_cycle", [], "any", false, false, false, 40) == "lifetime"); })) > 0)) {
            // line 41
            yield "      <button type=\"button\" class=\"px-6 py-3 text-sm font-medium rounded-full\"
        data-cycle=\"lifetime\" :class=\"{
          'bg-contrast-primary': cycle=='lifetime',
          'shadow': cycle=='lifetime'
        }\"
        @click=\"cycle='lifetime'\">";
            // line 46
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Lifetime Deals"), "html", null, true);
            yield "</button>
      ";
        }
        // line 48
        yield "    </div>
  </div>

  <div class=\"grid gap-12 mt-8 lg:mt-16 lg:grid-cols-2 xl:grid-cols-3\" x-cloak>
    ";
        // line 52
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["plans"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["plan"]) {
            // line 53
            yield "    <div
      class=\"enter p-[10px] rounded-4xl bg-contrast-secondary flex ";
            // line 54
            if (CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "is_featured", [], "any", false, false, false, 54)) {
                yield "bg-gradient-to-br from-[#E7FF9B] to-[#CFE6FF]";
            }
            yield "\"
      x-show=\"`";
            // line 55
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "billing_cycle", [], "any", false, false, false, 55), "html", null, true);
            yield "` == cycle\">
      <div class=\"w-full p-8 bg-contrast-primary rounded-3xl\">
        <div class=\"flex items-center justify-between\">
          ";
            // line 58
            if (CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "icon", [], "any", false, false, false, 58)) {
                // line 59
                yield "          <div
            class=\"flex items-center justify-center w-12 h-12 rounded-full shadow-md [&_svg]:w-8 [&_svg]:h-8\">
            ";
                // line 61
                if ((is_string($__internal_compile_0 = CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "icon", [], "any", false, false, false, 61)) && is_string($__internal_compile_1 = "<svg") && str_starts_with($__internal_compile_0, $__internal_compile_1))) {
                    // line 62
                    yield "            ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "icon", [], "any", false, false, false, 62);
                    yield "
            ";
                } else {
                    // line 64
                    yield "            <i class=\"ti ti-";
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "icon", [], "any", false, false, false, 64), "html", null, true);
                    yield " text-3xl\"></i>
            ";
                }
                // line 66
                yield "          </div>
          ";
            }
            // line 68
            yield "
          ";
            // line 69
            if (CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "is_featured", [], "any", false, false, false, 69)) {
                // line 70
                yield "          <div class=\"relative\">
            <div
              class=\"absolute top-1 left-1 w-full h-full rounded-lg bg-[#E7FF9B] flex bg-gradient-to-br from-[#E7FF9B] to-[#CFE6FF]\">
            </div>

            <div
              class=\"p-0.5 rounded-lg bg-[#E7FF9B] flex bg-gradient-to-br from-[#E7FF9B] to-[#CFE6FF] font-bold relative text-accent\">
              <span class=\"bg-[#E7FF9B] rounded-md py-1 px-2\">
                ";
                // line 78
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Most Popular"), "html", null, true);
                yield "
              </span>
            </div>

          </div>
          ";
            }
            // line 84
            yield "        </div>

        <h3 class=\"mt-6\">";
            // line 86
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "title", [], "any", false, false, false, 86), "html", null, true);
            yield "</h3>

        ";
            // line 88
            if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "description", [], "any", false, false, false, 88))) {
                // line 89
                yield "        <p class=\"text-tertiary\">";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "description", [], "any", false, false, false, 89), "html", null, true);
                yield "</p>
        ";
            }
            // line 91
            yield "
        <div class=\"mt-8\">
          <x-money class=\"text-4xl money\" data-value=\"";
            // line 93
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "price", [], "any", false, false, false, 93), "html", null, true);
            yield "\"
            currency=\"";
            // line 94
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["currency"] ?? null), "code", [], "any", false, false, false, 94), "html", null, true);
            yield "\"
            minor-units=\"";
            // line 95
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["currency"] ?? null), "fraction_digits", [], "any", false, false, false, 95), "html", null, true);
            yield "\" fraction=\"auto\">
          </x-money>

          <span class=\"text-tertiary\">/";
            // line 98
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "billing_cycle", [], "any", false, false, false, 98), "html", null, true);
            yield "</span>
        </div>

        <a href=\"/app/billing/checkout/";
            // line 101
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "id", [], "any", false, false, false, 101), "html", null, true);
            yield "\" class=\"flex mt-8 button\">
          ";
            // line 102
            yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "button", "Get started"), "html", null, true);
            yield "
        </a>

        <ul class=\"flex flex-col gap-4 mt-12\">
          ";
            // line 106
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, true, false, 106), "writer", [], "any", false, true, false, 106), "is_enabled", [], "any", true, true, false, 106) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, false, false, 106), "writer", [], "any", false, false, false, 106), "is_enabled", [], "any", false, false, false, 106))) {
                // line 107
                yield "          <li
            class=\"flex items-center gap-2 font-semibold ";
                // line 108
                yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 108), "writer", [], "any", false, false, false, 108), "is_enabled", [], "any", false, false, false, 108)) ? ("") : ("text-tertiary"));
                yield "\">
            ";
                // line 109
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 109), "writer", [], "any", false, false, false, 109), "is_enabled", [], "any", false, false, false, 109)) {
                    // line 110
                    yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                } else {
                    // line 112
                    yield "            <i class=\"text-2xl ti ti-square-rounded-x\"></i>
            ";
                }
                // line 114
                yield "
            ";
                // line 115
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Writer"), "html", null, true);
                yield "

            ";
                // line 117
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 117), "writer", [], "any", false, false, false, 117), "is_enabled", [], "any", false, false, false, 117)) {
                    // line 118
                    yield "            <div
              class=\"p-0.5 rounded-lg bg-[#E7FF9B] flex bg-gradient-to-br from-[#E7FF9B] to-[#CFE6FF] font-bold relative text-accent\">
              <span class=\"bg-[#E7FF9B] rounded-md py-1 px-2 text-xs\">
                ";
                    // line 121
                    yield ((CoreExtension::inFilter("gpt-4", CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 121), "writer", [], "any", false, false, false, 121), "model", [], "any", false, false, false, 121))) ? ("GPT 4") : ("GPT 3.5"));
                    yield "
              </span>
            </div>
            ";
                }
                // line 125
                yield "          </li>
          ";
            }
            // line 127
            yield "
          ";
            // line 128
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, true, false, 128), "coder", [], "any", false, true, false, 128), "is_enabled", [], "any", true, true, false, 128) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, false, false, 128), "coder", [], "any", false, false, false, 128), "is_enabled", [], "any", false, false, false, 128))) {
                // line 129
                yield "          <li
            class=\"flex items-center gap-2 font-semibold ";
                // line 130
                yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 130), "coder", [], "any", false, false, false, 130), "is_enabled", [], "any", false, false, false, 130)) ? ("") : ("text-tertiary"));
                yield "\">
            ";
                // line 131
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 131), "coder", [], "any", false, false, false, 131), "is_enabled", [], "any", false, false, false, 131)) {
                    // line 132
                    yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                } else {
                    // line 134
                    yield "            <i class=\"text-2xl ti ti-square-rounded-x\"></i>
            ";
                }
                // line 136
                yield "
            ";
                // line 137
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Coding Assistant"), "html", null, true);
                yield "

            ";
                // line 139
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 139), "coder", [], "any", false, false, false, 139), "is_enabled", [], "any", false, false, false, 139)) {
                    // line 140
                    yield "            <div
              class=\"p-0.5 rounded-lg bg-[#E7FF9B] flex bg-gradient-to-br from-[#E7FF9B] to-[#CFE6FF] font-bold relative text-accent\">
              <span class=\"bg-[#E7FF9B] rounded-md py-1 px-2 text-xs\">
                ";
                    // line 143
                    yield ((CoreExtension::inFilter("gpt-4", CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 143), "coder", [], "any", false, false, false, 143), "model", [], "any", false, false, false, 143))) ? ("GPT 4") : ("GPT 3.5"));
                    yield "
              </span>
            </div>
            ";
                }
                // line 147
                yield "          </li>
          ";
            }
            // line 149
            yield "
          ";
            // line 150
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, true, false, 150), "imagine", [], "any", false, true, false, 150), "is_enabled", [], "any", true, true, false, 150) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, false, false, 150), "imagine", [], "any", false, false, false, 150), "is_enabled", [], "any", false, false, false, 150))) {
                // line 151
                yield "          <li
            class=\"flex items-center gap-2 font-semibold ";
                // line 152
                yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 152), "imagine", [], "any", false, false, false, 152), "is_enabled", [], "any", false, false, false, 152)) ? ("") : ("text-tertiary"));
                yield "\">
            ";
                // line 153
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 153), "imagine", [], "any", false, false, false, 153), "is_enabled", [], "any", false, false, false, 153)) {
                    // line 154
                    yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                } else {
                    // line 156
                    yield "            <i class=\"text-2xl ti ti-square-rounded-x\"></i>
            ";
                }
                // line 158
                yield "
            ";
                // line 159
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Image generator"), "html", null, true);
                yield "
          </li>
          ";
            }
            // line 162
            yield "
          ";
            // line 163
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, true, false, 163), "transcriber", [], "any", false, true, false, 163), "is_enabled", [], "any", true, true, false, 163) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, false, false, 163), "transcriber", [], "any", false, false, false, 163), "is_enabled", [], "any", false, false, false, 163))) {
                // line 164
                yield "          <li
            class=\"flex items-center gap-2 font-semibold ";
                // line 165
                yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 165), "transcriber", [], "any", false, false, false, 165), "is_enabled", [], "any", false, false, false, 165)) ? ("") : ("text-tertiary"));
                yield "\">
            ";
                // line 166
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 166), "transcriber", [], "any", false, false, false, 166), "is_enabled", [], "any", false, false, false, 166)) {
                    // line 167
                    yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                } else {
                    // line 169
                    yield "            <i class=\"text-2xl ti ti-square-rounded-x\"></i>
            ";
                }
                // line 171
                yield "
            ";
                // line 172
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Transcriber"), "html", null, true);
                yield "
          </li>
          ";
            }
            // line 175
            yield "
          ";
            // line 176
            if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, true, false, 176), "voiceover", [], "any", false, true, false, 176), "is_enabled", [], "any", true, true, false, 176) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "features", [], "any", false, false, false, 176), "voiceover", [], "any", false, false, false, 176), "is_enabled", [], "any", false, false, false, 176))) {
                // line 177
                yield "          <li
            class=\"flex items-center gap-2 font-semibold ";
                // line 178
                yield ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 178), "voiceover", [], "any", false, false, false, 178), "is_enabled", [], "any", false, false, false, 178)) ? ("") : ("text-tertiary"));
                yield "\">
            ";
                // line 179
                if (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "config", [], "any", false, false, false, 179), "voiceover", [], "any", false, false, false, 179), "is_enabled", [], "any", false, false, false, 179)) {
                    // line 180
                    yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                } else {
                    // line 182
                    yield "            <i class=\"text-2xl ti ti-square-rounded-x\"></i>
            ";
                }
                // line 184
                yield "
            ";
                // line 185
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Voiceover"), "html", null, true);
                yield "
          </li>
          ";
            }
            // line 188
            yield "
          <li class=\"flex items-center gap-2 font-semibold\">
            ";
            // line 190
            if (((CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "credit_count", [], "any", false, false, false, 190) == 0) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "credit_count", [], "any", false, false, false, 190)))) {
                // line 191
                yield "            <i class=\"text-2xl ti ti-square-rounded-x text-tertiary\"></i>
            ";
                // line 192
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Access to templates is disabled"), "html", null, true);
                yield "
            ";
            } else {
                // line 194
                yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                // line 195
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Access to all templates"), "html", null, true);
                yield "
            ";
            }
            // line 197
            yield "          </li>

          <li class=\"flex items-center gap-2 font-semibold\">
            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>

            <x-credit data-value=\"";
            // line 202
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "credit_count", [], "any", false, false, false, 202), "html", null, true);
            yield "\"
              format=\"";
            // line 203
            yield Twig\Extension\EscaperExtension::escape($this->env, __(":count credits"), "html", null, true);
            yield "\"></x-credit>
          </li>

          <li class=\"flex items-center gap-2 font-semibold\">
            ";
            // line 207
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "price", [], "any", false, false, false, 207) > 0)) {
                // line 208
                yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                // line 209
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Priority support"), "html", null, true);
                yield "
            ";
            } else {
                // line 211
                yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                // line 212
                yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Basic support"), "html", null, true);
                yield "
            ";
            }
            // line 214
            yield "          </li>

          ";
            // line 216
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["plan"], "feature_list", [], "any", false, false, false, 216));
            foreach ($context['_seq'] as $context["_key"] => $context["li"]) {
                // line 217
                yield "          <li class=\"flex items-center gap-2 font-semibold\">
            ";
                // line 218
                if (CoreExtension::getAttribute($this->env, $this->source, $context["li"], "is_included", [], "any", false, false, false, 218)) {
                    // line 219
                    yield "            <i class=\"text-2xl ti ti-square-rounded-check-filled\"></i>
            ";
                } else {
                    // line 221
                    yield "            <i class=\"text-2xl ti ti-square-rounded-x text-tertiary\"></i>
            ";
                }
                // line 223
                yield "
            ";
                // line 224
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["li"], "title", [], "any", false, false, false, 224), "html", null, true);
                yield "
          </li>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['li'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 227
            yield "        </ul>
      </div>
    </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['plan'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 231
        yield "  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/pricing.twig";
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
        return array (  534 => 231,  525 => 227,  516 => 224,  513 => 223,  509 => 221,  505 => 219,  503 => 218,  500 => 217,  496 => 216,  492 => 214,  487 => 212,  484 => 211,  479 => 209,  476 => 208,  474 => 207,  467 => 203,  463 => 202,  456 => 197,  451 => 195,  448 => 194,  443 => 192,  440 => 191,  438 => 190,  434 => 188,  428 => 185,  425 => 184,  421 => 182,  417 => 180,  415 => 179,  411 => 178,  408 => 177,  406 => 176,  403 => 175,  397 => 172,  394 => 171,  390 => 169,  386 => 167,  384 => 166,  380 => 165,  377 => 164,  375 => 163,  372 => 162,  366 => 159,  363 => 158,  359 => 156,  355 => 154,  353 => 153,  349 => 152,  346 => 151,  344 => 150,  341 => 149,  337 => 147,  330 => 143,  325 => 140,  323 => 139,  318 => 137,  315 => 136,  311 => 134,  307 => 132,  305 => 131,  301 => 130,  298 => 129,  296 => 128,  293 => 127,  289 => 125,  282 => 121,  277 => 118,  275 => 117,  270 => 115,  267 => 114,  263 => 112,  259 => 110,  257 => 109,  253 => 108,  250 => 107,  248 => 106,  241 => 102,  237 => 101,  231 => 98,  225 => 95,  221 => 94,  217 => 93,  213 => 91,  207 => 89,  205 => 88,  200 => 86,  196 => 84,  187 => 78,  177 => 70,  175 => 69,  172 => 68,  168 => 66,  162 => 64,  156 => 62,  154 => 61,  150 => 59,  148 => 58,  142 => 55,  136 => 54,  133 => 53,  129 => 52,  123 => 48,  118 => 46,  111 => 41,  109 => 40,  106 => 39,  101 => 37,  94 => 32,  92 => 31,  89 => 30,  84 => 28,  77 => 23,  75 => 22,  72 => 21,  67 => 19,  60 => 14,  58 => 13,  48 => 6,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/pricing.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/pricing.twig");
    }
}
