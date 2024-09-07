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

/* /layouts/base.twig */
class __TwigTemplate_a135247a3012a873139964fb47dd6241 extends Template
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
            'layout' => [$this, 'block_layout'],
            'scripts' => [$this, 'block_scripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<!doctype html>
<html lang=\"";
        // line 2
        (((array_key_exists("locale", $context) &&  !(null === ($context["locale"] ?? null)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, ($context["locale"] ?? null), "html", null, true)) : (yield "en-US"));
        yield "\" class=\"group/html\"
  data-color-scheme=\"";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, json_encode((((CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", true, true, false, 3) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, false, false, 3)))) ? (CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, false, false, 3)) : ([]))), "html_attr");
        yield "\">

<head>
  ";
        // line 6
        yield from         $this->loadTemplate("snippets/script-tags/head.twig", "/layouts/base.twig", 6)->unwrap()->yield($context);
        // line 7
        yield "
  <meta charset=\"utf-8\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <meta name=\"viewport\" content=\"width=device-width,initial-scale=1\">
  <meta name=\"theme-color\" content=\"\">

  <base href=\"/\">

  <link rel=\"icon\" type=\"image/x-icon\"
    href=\"";
        // line 16
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 16), "favicon", [], "any", true, true, false, 16) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 16), "favicon", [], "any", false, false, false, 16)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "brand", [], "any", false, true, false, 16), "favicon", [], "any", false, false, false, 16), "html", null, true)) : (yield "assets/favicon.ico"));
        yield "\">

  <link rel=\"stylesheet\"
    href=\"https://unpkg.com/@tabler/icons-webfont@2.36.0/tabler-icons.min.css\" />
  <link rel=\"stylesheet\" href=\"assets/app.css?v=";
        // line 20
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
        yield "\">

  <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
  <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
  <link
    href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Serif:wght@100;300;400;500;600;700&display=swap\"
    rel=\"stylesheet\">

  ";
        // line 28
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "pwa", [], "any", false, true, false, 28), "is_enabled", [], "any", true, true, false, 28) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "pwa", [], "any", false, false, false, 28), "is_enabled", [], "any", false, false, false, 28))) {
            // line 29
            yield "  <link rel=\"manifest\" href=\"app.webmanifest\">
  ";
        }
        // line 31
        yield "
  <style>
    :root {
      /* Typography */
      --font-family-primary: 'Inter', sans-serif;
      --font-family-secondary: 'Inter', sans-serif;
      --font-family-editor: 'Inter', sans-serif;
      --font-family-editor-heading: 'Noto Serif';

      /* Theme colors */
      --color-accent: ";
        // line 41
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 41), "accent", [], "any", false, true, false, 41), "rgb", [], "any", true, true, false, 41) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 41), "accent", [], "any", false, true, false, 41), "rgb", [], "any", false, false, false, 41)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 41), "accent", [], "any", false, true, false, 41), "rgb", [], "any", false, false, false, 41), "html", null, true)) : (yield "211 243 107"));
        yield ";
      --color-accent-content: ";
        // line 42
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 42), "accent_content", [], "any", false, true, false, 42), "rgb", [], "any", true, true, false, 42) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 42), "accent_content", [], "any", false, true, false, 42), "rgb", [], "any", false, false, false, 42)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "color_scheme", [], "any", false, true, false, 42), "accent_content", [], "any", false, true, false, 42), "rgb", [], "any", false, false, false, 42), "html", null, true)) : (yield "63 66 70"));
        yield ";

      --color-main: 255 255 255;

      --color-content: 63 66 70;
      --color-content-dimmed: 172 174 175;
      --color-content-super-dimmed: 207 208 208;

      --color-line: 227 228 228;
      --color-line-dimmed: 245 246 246;
      --color-line-super-dimmed: 250 251 251;

      --color-intermediate: 245 246 246;
      --color-intermediate-content: 63 66 70;
      --color-intermediate-content-dimmed: 172 174 175;

      --color-button: 63 66 70;
      --color-button-content: 255 255 255;

      --color-button-dimmed: 245 246 246;
      --color-button-dimmed-content: 63 66 70;

      --color-button-accent: var(--color-accent);
      --color-button-accent-content: var(--color-accent-content);

      --color-gradient-from: 231 255 155;
      --color-gradient-to: 207 230 255;
      --color-gradient-content: 63 66 70;

      /* --------------- */
      --color-info: 0 166 251;
      --color-success: 48 200 98;
      --color-failure: 254 81 87;
      --color-alert: 254 212 73;
    }

    :root[data-mode=\"dark\"] {
      /* Theme colors */
      --color-main: 38 40 43;

      --color-content: 245 246 246;
      --color-content-dimmed: 172 174 175;
      --color-content-super-dimmed: 144 145 148;

      --color-line: 96 98 101;
      --color-line-dimmed: 63 66 70;
      --color-line-super-dimmed: 44 46 49;

      --color-intermediate: 25 26 28;
      --color-intermediate-content: 245 246 246;
      --color-intermediate-content-dimmed: 172 174 175;

      --color-button: 245 246 246;
      --color-button-content: 38 40 43;

      --color-button-dimmed: 96 98 101;
      --color-button-dimmed-content: 255 255 255;
    }
  </style>

  <script>
    // Prevent iframe hijacking
    this.top.location !== this.location && (this.top.location = this.location);

    if ('collapsed' in localStorage) {
      document.documentElement.dataset.collapsed = true;
    }
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

  <script>
    window.locale = {
      messages: {
        'An unexpected error occurred! Please try again later!': '";
        // line 144
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("An unexpected error occurred! Please try again later!"), "js"), "html", null, true);
        yield "',
        'Category has been updated successfully!': '";
        // line 145
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Category has been updated successfully!"), "js"), "html", null, true);
        yield "',
        'Category has been created successfully!': '";
        // line 146
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Category has been created successfully!"), "js"), "html", null, true);
        yield "',
        'Plan has been updated successfully!': '";
        // line 147
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Plan has been updated successfully!"), "js"), "html", null, true);
        yield "',
        'Plan has been created successfully!': '";
        // line 148
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Plan has been created successfully!"), "js"), "html", null, true);
        yield "',
        'Template has been updated successfully!': '";
        // line 149
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Template has been updated successfully!"), "js"), "html", null, true);
        yield "',
        'Template has been created successfully!': '";
        // line 150
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Template has been created successfully!"), "js"), "html", null, true);
        yield "',
        'Changes saved successfully!': '";
        // line 151
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Changes saved successfully!"), "js"), "html", null, true);
        yield "',
        'Cache cleared successfully!': '";
        // line 152
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Cache cleared successfully!"), "js"), "html", null, true);
        yield "',
        'User has been updated successfully!': '";
        // line 153
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("User has been updated successfully!"), "js"), "html", null, true);
        yield "',
        'User has been created successfully!': '";
        // line 154
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("User has been created successfully!"), "js"), "html", null, true);
        yield "',
        'Email sent successfully!': '";
        // line 155
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Email sent successfully!"), "js"), "html", null, true);
        yield "',
        'You have run out of credits. Please purchase more credits to continue using the app.': '";
        // line 156
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("You have run out of credits. Please purchase more credits to continue using the app."), "js"), "html", null, true);
        yield "',
        'Document copied to clipboard!': '";
        // line 157
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Document copied to clipboard!"), "js"), "html", null, true);
        yield "',
        'Document saved successfully!': '";
        // line 158
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Document saved successfully!"), "js"), "html", null, true);
        yield "',
        'Document deleted successfully!': '";
        // line 159
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Document deleted successfully!"), "js"), "html", null, true);
        yield "',
        'Subscription cancelled!': '";
        // line 160
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Subscription cancelled!"), "js"), "html", null, true);
        yield "',
        'Document has been updated successfully!': '";
        // line 161
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Document has been updated successfully!"), "js"), "html", null, true);
        yield "',
        'Image copied to clipboard!': '";
        // line 162
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Image copied to clipboard!"), "js"), "html", null, true);
        yield "',
        'Authentication failed! Please check your credentials and try again!': '";
        // line 163
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Authentication failed! Please check your credentials and try again!"), "js"), "html", null, true);
        yield "',
        'Click to copy': '";
        // line 164
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Click to copy"), "js"), "html", null, true);
        yield "',
        'Copied to clipboard': '";
        // line 165
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Copied to clipboard"), "js"), "html", null, true);
        yield "',
        'Resource UUID is copied to the clipboard.': '";
        // line 166
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Resource UUID is copied to the clipboard."), "js"), "html", null, true);
        yield "',
        'Workspace name updated!': '";
        // line 167
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Workspace name updated!"), "js"), "html", null, true);
        yield "',
        'You\\'ve been added to the :name workspace!': '";
        // line 168
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("You've been added to the :name workspace!"), "js"), "html", null, true);
        yield "',
        'Your card number is incomplete.': '";
        // line 169
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Your card number is incomplete."), "js"), "html", null, true);
        yield "',
        'Invalid card number': '";
        // line 170
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Invalid card number"), "js"), "html", null, true);
        yield "',
        'Your card\\'s security code is incomplete.': '";
        // line 171
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Your card's security code is incomplete."), "js"), "html", null, true);
        yield "',
        'Your card\\'s security code is invalid.': '";
        // line 172
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Your card's security code is invalid."), "js"), "html", null, true);
        yield "',
        'Your card\\'s expiration date is incomplete.': '";
        // line 173
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Your card's expiration date is incomplete."), "js"), "html", null, true);
        yield "',
        'Your card\\'s expiration date is invalid.': '";
        // line 174
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Your card's expiration date is invalid."), "js"), "html", null, true);
        yield "',
        'Insufficient credits': '";
        // line 175
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Insufficient credits to perform this operation."), "js"), "html", null, true);
        yield "',
        'Copied to clipboard!': '";
        // line 176
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\EscaperExtension::escape($this->env, __("Copied to clipboard!"), "js"), "html", null, true);
        yield "',
      },
    }

    document.cookie = `locale=";
        // line 180
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["locale"] ?? null), "html", null, true);
        yield "; expires=\${new Date(new Date().getTime() + 1000 * 60 * 60 * 24 * 365).toGMTString()}; path=/`
  </script>

  <script type=\"\">
    window.state = {
      user: ";
        // line 185
        yield ((array_key_exists("user", $context)) ? (json_encode(($context["user"] ?? null))) : ("{}"));
        yield ",
      workspace: ";
        // line 186
        yield ((array_key_exists("workspace", $context)) ? (json_encode(($context["workspace"] ?? null))) : ("{}"));
        yield ",
    };
  </script>

  <title>
    ";
        // line 191
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        // line 192
        yield "    ";
        yield (((( !Twig\Extension\CoreExtension::testEmpty(        $this->unwrap()->renderBlock("title", $context, $blocks)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 192), "name", [], "any", true, true, false, 192)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, false, false, 192), "name", [], "any", false, false, false, 192))) ? (" | ") : (""));
        yield "
    ";
        // line 193
        (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 193), "name", [], "any", true, true, false, 193) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 193), "name", [], "any", false, false, false, 193)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "site", [], "any", false, true, false, 193), "name", [], "any", false, false, false, 193), "html", null, true)) : (yield null));
        yield "
  </title>
</head>

<body
  class=\"bg-main text-content max-h-screen font-content data-[modal]:overflow-hidden data-[modal]:pr-[var(--scrollbar-width)] group/body\"
  x-data='";
        // line 199
        ((array_key_exists("xdata", $context)) ? (yield Twig\Extension\EscaperExtension::escape($this->env, ($context["xdata"] ?? null), "html", null, true)) : (yield ""));
        yield "'>
  ";
        // line 200
        yield from         $this->loadTemplate("snippets/script-tags/body.twig", "/layouts/base.twig", 200)->unwrap()->yield($context);
        // line 201
        yield "
  <toast-message
    class=\"";
        // line 203
        yield ((CoreExtension::inFilter(($context["view_namespace"] ?? null), ["app", "admin"])) ? ("lg:ml-[7.5rem]") : (""));
        yield " fixed left-1/2 z-50 -bottom-20 opacity-0 invisible data-[open]:bottom-4 md:data-[open]:bottom-12 mb-1 data-[open]:opacity-100 data-[open]:visible flex items-center gap-3 rounded-lg -translate-x-1/2 px-4 py-3 bg-content text-main transition-all group/toast md:max-w-[28rem] max-w-max w-[90%] md:w-auto\">
  </toast-message>

  ";
        // line 206
        yield from $this->unwrap()->yieldBlock('layout', $context, $blocks);
        // line 207
        yield "
  <script src=\"assets/base.js?v=";
        // line 208
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
        yield "\"></script>
  ";
        // line 209
        yield from $this->unwrap()->yieldBlock('scripts', $context, $blocks);
        // line 210
        yield "
  ";
        // line 211
        yield from         $this->loadTemplate("snippets/script-tags/end.twig", "/layouts/base.twig", 211)->unwrap()->yield($context);
        // line 212
        yield "</body>

</html>";
        return; yield '';
    }

    // line 191
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 206
    public function block_layout($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    // line 209
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/layouts/base.twig";
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
        return array (  436 => 209,  429 => 206,  422 => 191,  415 => 212,  413 => 211,  410 => 210,  408 => 209,  404 => 208,  401 => 207,  399 => 206,  393 => 203,  389 => 201,  387 => 200,  383 => 199,  374 => 193,  369 => 192,  367 => 191,  359 => 186,  355 => 185,  347 => 180,  340 => 176,  336 => 175,  332 => 174,  328 => 173,  324 => 172,  320 => 171,  316 => 170,  312 => 169,  308 => 168,  304 => 167,  300 => 166,  296 => 165,  292 => 164,  288 => 163,  284 => 162,  280 => 161,  276 => 160,  272 => 159,  268 => 158,  264 => 157,  260 => 156,  256 => 155,  252 => 154,  248 => 153,  244 => 152,  240 => 151,  236 => 150,  232 => 149,  228 => 148,  224 => 147,  220 => 146,  216 => 145,  212 => 144,  107 => 42,  103 => 41,  91 => 31,  87 => 29,  85 => 28,  74 => 20,  67 => 16,  56 => 7,  54 => 6,  48 => 3,  44 => 2,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/layouts/base.twig", "/home/u489518759/domains/renvon.com/resources/views/layouts/base.twig");
    }
}
