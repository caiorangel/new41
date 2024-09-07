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

/* @theme/layouts/theme.twig */
class __TwigTemplate_6110ebf698e74fc9eca4cf1ee056b902 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'template' => [$this, 'block_template'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<!doctype html>
<html lang=\"";
        // line 2
        (((array_key_exists("theme_locale", $context) &&  !(null === ($context["theme_locale"] ?? null)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, ($context["theme_locale"] ?? null), "html", null, true)) : (yield "en-US"));
        yield "\"
  data-color-scheme=\"";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, json_encode((((CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", true, true, false, 3) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, false, false, 3)))) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, false, false, 3)) : ([]))), "html_attr");
        yield "\"
  class=\"group/html\">

<head>
  ";
        // line 7
        yield from         $this->loadTemplate("@theme/snippets/script-tags/head.twig", "@theme/layouts/theme.twig", 7)->unwrap()->yield($context);
        // line 8
        yield "
  <meta charset=\"utf-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">
  <meta name=\"theme-color\" content=\"\">

  <link rel=\"icon\" type=\"image/x-icon\"
    href=\"";
        // line 15
        yield Twig\Extension\EscaperExtension::escape($this->env, (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 15), "favicon", [], "any", true, true, false, 15) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 15), "favicon", [], "any", false, false, false, 15)))) ? (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 15), "favicon", [], "any", false, false, false, 15)) : ($this->env->getFilter('asset_url')->getCallable()("favicon.ico"))), "html", null, true);
        yield "\">

  <link rel=\"stylesheet\"
    href=\"https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.34.0/tabler-icons.min.css\" />
  <link rel=\"stylesheet\" href=\"";
        // line 19
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("theme.css"), "html", null, true);
        yield "\">

  <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
  <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
  <link
    href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Serif:wght@100;300;400;500;600;700&display=swap\"
    rel=\"stylesheet\">

  <meta name=\"description\" content=\"";
        // line 27
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 27), "description", [], "any", true, true, false, 27) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 27), "description", [], "any", false, false, false, 27)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 27), "description", [], "any", false, false, false, 27), "html", null, true)) : (yield null));
        yield "\">
  <meta name=\"keywords\" content=\"";
        // line 28
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 28), "keywords", [], "any", true, true, false, 28) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 28), "keywords", [], "any", false, false, false, 28)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 28), "keywords", [], "any", false, false, false, 28), "html", null, true)) : (yield null));
        yield "\">

  <style>
    :root {
      /* Typography */
      --font-family-primary: 'Inter', sans-serif;
      --font-family-secondary: 'Inter', sans-serif;
      --font-family-editor: 'Inter', sans-serif;
      --font-family-editor-heading: 'Noto Serif';

      /* Theme colors */

      /* Primary text color */
      /* Solid/Gray/Dark/Gray - 700 (Dark) */
      --color-primary: 36 40 44;

      /* Secondary text color (sidebar menu) */
      /* Solid/Gray/Dark/Gray - 500 (Dark) */
      --color-secondary: 90 93 96;

      /* Tertiary text color */
      /* Solid/Gray/Dark/Gray - 200 (Dark) */
      --color-tertiary: 172 174 175;

      /* Solid/Gray/Dark/Gray - 700 (Dark) */
      --color-accent: 36 40 44;

      /* Primary background color */
      --color-contrast-primary: 255 255 255;

      /* Secondary background color (cards, sidebar) */
      /* Solid/Gray/Dark/Gray - 25 (Dark) */
      --color-contrast-secondary: 245 246 246;

      /* Solid/Primary/Main-1/Brand - 700 V1 */
      --color-contrast-accent: 211 243 107;

      /* Solid/Gray/Dark/Gray - 100 (Dark) state:active, hover */
      --color-line-primary: 200 201 202;

      /* Solid/Gray/Dark/Gray - 50 (Dark) inputs */
      --color-line-secondary: 227 228 228;

      /* Solid/Gray/Dark/Gray - 25 (Dark) state: normal */
      --color-line-tertiary: 245 246 246;

      /* Solid/Gray/Dark/Gray - 700 (Dark) */
      --color-line-accent: 36 40 44;

      /* Solid/Notifications/Information/Info - 700 */
      --color-info: 0 166 251;

      /* Solid/Notifications/Success/Success - 700 */
      --color-success: 48 200 98;

      /* Solid/Notifications/Fail/Fail - 700 */
      --color-failure: 254 81 87;
    }

    :root[data-mode=\"dark\"] {
      /* Theme colors */

      /* Primary text color */
      /* Solid/Gray/Dark/Gray - 50 (Dark) */
      --color-primary: 227 228 228;

      /* Secondary text color (sidebar menu) */
      /* Solid/Gray/Dark/Gray - 200 (Dark) */
      --color-secondary: 172 174 175;

      /* Tertiary text color */
      /* Solid/Gray/Dark/Gray - 400 (Dark) */
      --color-tertiary: 118 120 123;

      /* Primary background color */
      /* Solid/Gray/Dark/Gray - 700 (Dark) */
      --color-contrast-primary: 36 40 44;

      /* Secondary background color (cards, sidebar) */
      /* Solid/Gray/Dark/Gray - 800 (Dark) */
      --color-contrast-secondary: 22 25 27;
      /* Solid/Gray/Dark/Gray - 600 (Dark) */
      /*--color-contrast-secondary: 63 66 70;*/

      /* Solid/Gray/Dark/Gray - 300 (Dark) */
      --color-line-primary: 145 147 149;

      /* Solid/Gray/Dark/Gray - 400 (Dark) */
      --color-line-secondary: 118 120 123;

      /* Solid/Gray/Dark/Gray - 600 (Dark) */
      --color-line-tertiary: 63 66 70;

      /* Solid/Primary/Main-1/Brand - 700 V1 */
      --color-line-accent: 211 243 107;
    }
  </style>

  <title>
    ";
        // line 127
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        // line 128
        yield "    ";
        yield ((Twig\Extension\CoreExtension::testEmpty(        $this->unwrap()->renderBlock("title", $context, $blocks))) ? ("") : (" | "));
        yield "
    ";
        // line 129
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 129), "name", [], "any", true, true, false, 129) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 129), "name", [], "any", false, false, false, 129)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 129), "name", [], "any", false, false, false, 129), "html", null, true)) : (yield null));
        yield "
  </title>

  <script>
    window.currency = JSON.parse('";
        // line 133
        yield json_encode(($context["currency"] ?? null));
        yield "');
    document.cookie = `locale=";
        // line 134
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["theme_locale"] ?? null), "html", null, true);
        yield "; expires=\${new Date(new Date().getTime() + 1000 * 60 * 60 * 24 * 365).toGMTString()}; path=/`
  </script>

  <script>
    let scheme = {
      ...{
        modes: ['light', 'dark'],
        default: 'system',
      },
      ...JSON.parse(document.documentElement.dataset.colorScheme),
    };

    if (scheme.modes.length > 1) {
      if (!('mode' in localStorage) || scheme.modes.indexOf(localStorage.mode) === -1) {
        if (scheme.default === 'system') {
          localStorage.mode = window.matchMedia('(prefers-color-scheme: dark)').matches
            ? 'dark'
            : 'light';
        } else {
          localStorage.mode = scheme.default;
        }
      }
    } else if (scheme.modes.length === 1) {
      localStorage.mode = scheme.modes[0];
    } else {
      localStorage.mode = window.matchMedia('(prefers-color-scheme: dark)').matches
        ? 'dark'
        : 'light';
    }

    document.documentElement.dataset.mode = localStorage.mode;
  </script>
</head>

<body
  class=\"bg-contrast-primary text-primary font-primary data-[overlay]:overflow-hidden data-[overlay]:pr-[var(--scrollbar-width)] group/body\"
  x-data=\"\">
  ";
        // line 171
        yield from         $this->loadTemplate("@theme/snippets/script-tags/body.twig", "@theme/layouts/theme.twig", 171)->unwrap()->yield($context);
        // line 172
        yield "
  <div class=\"container\">
    ";
        // line 174
        yield from         $this->loadTemplate("@theme/sections/header.twig", "@theme/layouts/theme.twig", 174)->unwrap()->yield($context);
        // line 175
        yield "    ";
        yield from $this->unwrap()->yieldBlock('template', $context, $blocks);
        // line 176
        yield "    ";
        yield from         $this->loadTemplate("@theme/sections/footer.twig", "@theme/layouts/theme.twig", 176)->unwrap()->yield($context);
        // line 177
        yield "  </div>

  <script src=\"";
        // line 179
        yield Twig\Extension\EscaperExtension::escape($this->env, $this->env->getFilter('asset_url')->getCallable()("theme.js"), "html", null, true);
        yield "\"></script>

  ";
        // line 181
        yield from         $this->loadTemplate("@theme/snippets/script-tags/end.twig", "@theme/layouts/theme.twig", 181)->unwrap()->yield($context);
        // line 182
        yield "</body>

</html>";
        return; yield '';
    }

    // line 127
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 175
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/layouts/theme.twig";
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
        return array (  286 => 175,  279 => 127,  272 => 182,  270 => 181,  265 => 179,  261 => 177,  258 => 176,  255 => 175,  253 => 174,  249 => 172,  247 => 171,  207 => 134,  203 => 133,  196 => 129,  191 => 128,  189 => 127,  87 => 28,  83 => 27,  72 => 19,  65 => 15,  56 => 8,  54 => 7,  47 => 3,  43 => 2,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/layouts/theme.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/layouts/theme.twig");
    }
}
