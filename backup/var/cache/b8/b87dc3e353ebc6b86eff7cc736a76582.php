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

/* templates/install/index.twig */
class __TwigTemplate_0d3dbbec81ef0dc7617851b816398b3c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'layout' => [$this, 'block_layout'],
            'scripts' => [$this, 'block_scripts'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "/layouts/base.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        $context["xdata"] = ('' === $tmp = \Twig\Extension\CoreExtension::captureOutput((function () use (&$context, $macros, $blocks) {
            // line 4
            yield "installer(`";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
            yield "`, `";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["ip"] ?? null), "html", null, true);
            yield "`)
";
        })() ?? new \EmptyIterator())) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 1
        $this->parent = $this->loadTemplate("/layouts/base.twig", "templates/install/index.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 6
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Installation")), "html", null, true);
        return; yield '';
    }

    // line 8
    public function block_layout($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 9
        yield "<div class=\"container\">
  <div class=\"flex flex-col max-w-2xl gap-10 mx-auto\">
    ";
        // line 11
        yield from         $this->loadTemplate("snippets/install/header.twig", "templates/install/index.twig", 11)->unwrap()->yield($context);
        // line 12
        yield "
    <div class=\"box\" data-density=\"comfortable\" x-ref=\"loading\">
      <div class=\"flex flex-col items-center gap-2 text-center\">
        <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"
          xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\"
          width=\"32px\" height=\"32px\" viewBox=\"0 0 50 50\"
          style=\"enable-background:new 0 0 50 50;\" class=\"spinner\"
          xml:space=\"preserve\">
          <path fill=\"currentColor\"
            d=\"M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z\">
            <animateTransform attributeType=\"xml\" attributeName=\"transform\"
              type=\"rotate\" from=\"0 25 25\" to=\"360 25 25\" dur=\"0.6s\"
              repeatCount=\"indefinite\"></animateTransform>
          </path>
        </svg>

        <span class=\"text-xs text-content-dimmed\">
          ";
        // line 29
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Initializing..."), "html", null, true);
        yield "
        </span>
      </div>
    </div>

    <div class=\"box\" data-density=\"comfortable\" x-cloak>
      ";
        // line 35
        $context["steps"] = ["welcome", "requirements", "license", "db", "migration", "account", "success", "failure"];
        // line 36
        yield "
      ";
        // line 37
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["steps"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["step"]) {
            // line 38
            yield "      <template x-if=\"step == '";
            yield Twig\Extension\EscaperExtension::escape($this->env, $context["step"], "html", null, true);
            yield "'\">
        ";
            // line 39
            yield from             $this->loadTemplate((("snippets/install/" . $context["step"]) . ".twig"), "templates/install/index.twig", 39)->unwrap()->yield($context);
            // line 40
            yield "      </template>
      ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['step'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        yield "    </div>

    <div class=\"text-xs leading-5 text-content-dimmed\">
      Made by humans on Planet Earth. <br>
      &copy; ";
        // line 46
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::dateFormatFilter($this->env, "now", "Y"), "html", null, true);
        yield " <a href=\"https://aikeedo.com\"
        target=\"_blank\">Aikeedo</a>. All rights reserved.
    </div>
  </div>
</div>
";
        return; yield '';
    }

    // line 53
    public function block_scripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 54
        yield "<script src=\"assets/install.js?v=";
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
        return "templates/install/index.twig";
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
        return array (  171 => 54,  167 => 53,  156 => 46,  150 => 42,  135 => 40,  133 => 39,  128 => 38,  111 => 37,  108 => 36,  106 => 35,  97 => 29,  78 => 12,  76 => 11,  72 => 9,  68 => 8,  60 => 6,  55 => 1,  47 => 4,  45 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "templates/install/index.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/install/index.twig");
    }
}
