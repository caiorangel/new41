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

/* @theme/sections/features.twig */
class __TwigTemplate_d53395aad35a353bd92f3f6ce05b8dc6 extends Template
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
        yield "<div id=\"features\">
  <h2 class=\"text-center enter\">
    ";
        // line 3
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Coolest Features"), "html", null, true);
        yield "
  </h2>

  <div class=\"grid gap-6 mt-6 sm:grid-cols-2 md:gap-12 lg:grid-cols-3 lg:mt-10\">
    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-code\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "High Quality Code"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 16
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Developed by Using Domain-Driven Design and Onion Architecture Principles."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-sparkles\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 26
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Modern Technologies"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 29
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Built with modern technologies for best structure and get maximum performance."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-click\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 39
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Friendly UI and UX"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 42
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Enjoy a hassle-free and intuitive user interface that enhances your digital experience."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-moon\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 52
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Dark Mode"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 55
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Turn off the light and switch to dark mode your interface with one click."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-file-description\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 65
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Documentation"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 68
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "An all-inclusive learning package seamlessly integrated into our community."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-credit-card\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 78
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Payment Gateways"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 81
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Simplify transactions and boost security with payment gateway solutions."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-cpu-2\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 91
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "AI Generator"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 94
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Unlock limitless creativity with our AI-powered content generator."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-database-search\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 104
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "SEO Friendly"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 107
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Boost your visibility and reach your audience effectively with AI generated content."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-layout-grid\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 117
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Advanced Dashboard"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 120
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Empower your insights and control with our cutting-edge dashboard."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-layout-dashboard\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 130
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Custom Templates"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 133
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Transform your content creation with AI-driven custom templates."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-brand-facebook\"></i>
      </span>


      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 144
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "Login via SM Accounts"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 147
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Use Facebook or Google accounts as an alternatively access to platform."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"p-8 wrapper enter3\">
      <span class=\"icon shadow-right\">
        <i class=\"ti ti-headset\"></i>
      </span>

      <h3 class=\"mt-10 lg:text-2xl\">
        ";
        // line 157
        yield Twig\Extension\EscaperExtension::escape($this->env, dp__("theme", "heading", "High Quality Support"), "html", null, true);
        yield "
      </h3>
      <p class=\"mt-4 font-medium md:text-lg\">
        ";
        // line 160
        yield Twig\Extension\EscaperExtension::escape($this->env, d__("theme", "Our support team is available 24/7 to help you with any questions or concerns."), "html", null, true);
        yield "
      </p>
    </div>
  </div>
</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@theme/sections/features.twig";
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
        return array (  271 => 160,  265 => 157,  252 => 147,  246 => 144,  232 => 133,  226 => 130,  213 => 120,  207 => 117,  194 => 107,  188 => 104,  175 => 94,  169 => 91,  156 => 81,  150 => 78,  137 => 68,  131 => 65,  118 => 55,  112 => 52,  99 => 42,  93 => 39,  80 => 29,  74 => 26,  61 => 16,  55 => 13,  42 => 3,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "@theme/sections/features.twig", "/home/u489518759/domains/renvon.com/public_html/content/plugins/heyaikeedo/default/sections/features.twig");
    }
}
