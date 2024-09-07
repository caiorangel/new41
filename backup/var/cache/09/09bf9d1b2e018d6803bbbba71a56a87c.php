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

/* /snippets/captcha.twig */
class __TwigTemplate_a623bb98fe113c31433c0201ceb10bc2 extends Template
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
        if ((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "recaptcha", [], "any", false, true, false, 1), "is_enabled", [], "any", true, true, false, 1) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "recaptcha", [], "any", false, false, false, 1), "is_enabled", [], "any", false, false, false, 1))) {
            // line 2
            yield "<div>
  <div class=\"box bg-intermediate border-line dark:border-line-dimmed group\">
    <input type=\"text\" id=\"captcha-token\" name=\"captcha-token\" required
      class=\"hidden\">

    <div class=\"flex items-center gap-2 cursor-pointer\"
      @click=\"grecaptcha.execute()\">
      <input type=\"checkbox\" class=\"hidden peer\" id=\"captcha-checkbox\">

      <i
        class=\"text-3xl ti ti-square-rounded text-content-dimmed peer-checked:hidden\"></i>
      <i
        class=\"hidden text-3xl ti ti-square-rounded-check-filled text-success peer-checked:block\"></i>

      <div class=\"font-normal select-none\">
        <span>";
            // line 17
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "I'm not a robot"), "html", null, true);
            yield "</span>

        <div class=\"text-xs text-content-dimmed group-hover:hidden\">
          ";
            // line 20
            yield Twig\Extension\EscaperExtension::escape($this->env, __("Protected by Google reCAPTCHA"), "html", null, true);
            yield "
        </div>

        <div class=\"hidden text-xs text-content-dimmed group-hover:block\">
          <a href=\"https://www.google.com/intl/en/policies/privacy/\"
            class=\"hover:underline\" target=\"_blank\">
            ";
            // line 26
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Privacy Policy"), "html", null, true);
            yield "
          </a> /
          <a href=\"https://www.google.com/intl/en/policies/terms/\"
            class=\"hover:underline\" target=\"_blank\">
            ";
            // line 30
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Terms of Service"), "html", null, true);
            yield "
          </a>
        </div>
      </div>

      <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"32\" height=\"32\"
        viewBox=\"0 0 64 64\" class=\"hidden ml-auto md:block\">
        <path
          d=\"M64 31.955l-.033-1.37V4.687l-7.16 7.16C50.948 4.674 42.033.093 32.05.093c-10.4 0-19.622 4.96-25.458 12.64l11.736 11.86a15.55 15.55 0 0 1 4.754-5.334c2.05-1.6 4.952-2.906 8.968-2.906.485 0 .86.057 1.135.163 4.976.393 9.288 3.14 11.828 7.124l-8.307 8.307L64 31.953\"
          fill=\"#1c3aa9\" />
        <path
          d=\"M31.862.094l-1.37.033H4.594l7.16 7.16C4.58 13.147 0 22.06 0 32.046c0 10.4 4.96 19.622 12.64 25.458L24.5 45.768a15.55 15.55 0 0 1-5.334-4.754c-1.6-2.05-2.906-4.952-2.906-8.968 0-.485.057-.86.163-1.135.393-4.976 3.14-9.288 7.124-11.828l8.307 8.307L31.86.095\"
          fill=\"#4285f4\" />
        <path
          d=\"M.001 32.045l.033 1.37v25.898l7.16-7.16c5.86 7.173 14.774 11.754 24.76 11.754 10.4 0 19.622-4.96 25.458-12.64l-11.736-11.86a15.55 15.55 0 0 1-4.754 5.334c-2.05 1.6-4.952 2.906-8.968 2.906-.485 0-.86-.057-1.135-.163-4.976-.393-9.288-3.14-11.828-7.124l8.307-8.307c-10.522.04-22.4.066-27.295-.005\"
          fill=\"#ababab\" />
      </svg>
    </div>
  </div>

  <script type=\"text/javascript\">
    window.captcha = {
      el: document.getElementById(\"captcha-token\"),
      checkbox: document.getElementById(\"captcha-checkbox\"),
      reset: function () {
        recaptchaExpired();
        grecaptcha.reset(document.getElementById('g-recaptcha'))
      },
    }

    function recaptchaCallback(token) {
      window.captcha.checkbox.disabled = true;
      window.captcha.checkbox.checked = true;

      window.captcha.el.value = token;
      window.captcha.el.dispatchEvent(new Event('input', {
        bubbles: true,
      }));
    }

    function recaptchaExpired() {
      window.captcha.checkbox.disabled = false;
      window.captcha.checkbox.checked = false;

      window.captcha.el.value = '';
      window.captcha.el.dispatchEvent(new Event('input', {
        bubbles: true,
      }));
    }
  </script>
  <script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>

  <div x-ref=\"recaptcha\" class=\"hidden g-recaptcha\" id=\"g-recaptcha\"
    data-sitekey=\"";
            // line 83
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "recaptcha", [], "any", false, false, false, 83), "site_key", [], "any", false, false, false, 83), "html", null, true);
            yield "\" data-size=\"invisible\"
    data-callback=\"recaptchaCallback\" data-expired-callback=\"recaptchaExpired\"
    data-error-callback=\"recaptchaExpired\"></div>
</div>
";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/snippets/captcha.twig";
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
        return array (  135 => 83,  79 => 30,  72 => 26,  63 => 20,  57 => 17,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/snippets/captcha.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/captcha.twig");
    }
}
