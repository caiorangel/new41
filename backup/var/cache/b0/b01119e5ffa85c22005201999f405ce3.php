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

/* /templates/admin/update.twig */
class __TwigTemplate_30da8aaf4904541ec2b6b66b30317978 extends Template
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
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "/layouts/main.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        $context["active_menu"] = "update";
        // line 4
        $context["xdata"] = "update";
        // line 1
        $this->parent = $this->loadTemplate("/layouts/main.twig", "/templates/admin/update.twig", 1);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        yield Twig\Extension\EscaperExtension::escape($this->env, Twig\Extension\CoreExtension::titleStringFilter($this->env, p__("title", "Update")), "html", null, true);
        return; yield '';
    }

    // line 7
    public function block_template($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 8
        yield "<div class=\"flex flex-col gap-8\" @submit.prevent=\"\">
  <div>
    ";
        // line 10
        yield from         $this->loadTemplate("snippets/back.twig", "/templates/admin/update.twig", 10)->unwrap()->yield(CoreExtension::arrayMerge($context, ["link" => "admin", "label" => "Dashboard"]));
        // line 11
        yield "
    <h1 class=\"mt-4\">
      ";
        // line 13
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("title", "Update"), "html", null, true);
        yield "
    </h1>
  </div>

  <div class=\"flex flex-col gap-2\">
    <section class=\"flex flex-col gap-6 box \" data-density=\"comfortable\">
      <h2>";
        // line 19
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "About"), "html", null, true);
        yield "</h2>

      <div class=\"flex gap-6\">
        <div>
          <div class=\"label\">";
        // line 23
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "License"), "html", null, true);
        yield "</div>
          <div class=\"flex mt-1\">
            <div>
              ";
        // line 26
        if (($context["license"] ?? null)) {
            // line 27
            yield "              <x-copy class=\"flex items-center badge\" data-copy=\"";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["license"] ?? null), "html", null, true);
            yield "\">

                <span class=\"font-bold capitalize\">
                  ";
            // line 30
            yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Key"), "html", null, true);
            yield "
                </span>

                <span
                  x-text=\"'";
            // line 34
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["license"] ?? null), "html", null, true);
            yield "'.slice(0,4) + '*'.repeat(10) + '";
            yield Twig\Extension\EscaperExtension::escape($this->env, ($context["license"] ?? null), "html", null, true);
            yield "'.slice(-4)\">
                </span>
              </x-copy>
              ";
        } else {
            // line 38
            yield "              <span class=\"text-xs\">
                ";
            // line 39
            yield Twig\Extension\EscaperExtension::escape($this->env, __("Couldn’t identify the license"), "html", null, true);
            yield "
              </span>
              ";
        }
        // line 42
        yield "            </div>
          </div>
        </div>

        <div>
          <div class=\"label\">";
        // line 47
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Installed"), "html", null, true);
        yield "</div>
          <div class=\"flex mt-1\">
            <div>
              <x-copy class=\"flex items-center badge\" data-copy=\"";
        // line 50
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
        yield "\">

                <span class=\"font-bold capitalize\">
                  ";
        // line 53
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("label", "Version"), "html", null, true);
        yield "
                </span>

                <span>";
        // line 56
        yield Twig\Extension\EscaperExtension::escape($this->env, ($context["version"] ?? null), "html", null, true);
        yield "</span>
              </x-copy>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class=\"p-8 box\">
      <div class=\"flex items-center gap-4\">
        <span
          class=\"flex items-center justify-center w-10 h-10 bg-intermediate text-intermediate-content\"
          :class=\"file ? 'rounded-lg' : 'rounded-full'\">
          <i class=\"ti\" :class=\"file ? 'ti-file-zip' : 'ti-paperclip'\"></i>
        </span>

        <template x-if=\"file\">
          <div>
            <div class=\"font-medium\" x-text=\"file.name\"></div>

            <template x-if=\"error\">
              <div class=\"text-sm text-failure\" x-text=\"error\"></div>
            </template>

            <template x-if=\"!error\">
              <div class=\"text-sm text-content-dimmed\" x-text=\"filesize\"></div>
            </template>
          </div>
        </template>

        <template x-if=\"!file\">
          <div>
            <div class=\"font-medium\">
              ";
        // line 89
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Choose a file of the updated version"), "html", null, true);
        yield "
            </div>

            <template x-if=\"error\">
              <div class=\"text-sm text-failure\" x-text=\"error\"></div>
            </template>

            <template x-if=\"!error\">
              <div class=\"text-sm text-content-dimmed\">
                ";
        // line 98
        yield Twig\Extension\EscaperExtension::escape($this->env, __("ZIP archive file only"), "html", null, true);
        yield "
              </div>
            </template>
          </div>
        </template>

        <button type=\"button\" class=\"ml-auto button button-outline button-sm\"
          @click=\"\$refs.file.click()\" :disabled=\"isProcessing\"
          x-text=\"file ? `";
        // line 106
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Change file"), "html", null, true);
        yield "` : `";
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Choose file"), "html", null, true);
        yield "`\">
        </button>

        <template x-if=\"file\">
          <button type=\"button\" class=\"button button-sm button-accent\"
            :processing=\"isProcessing\" :disabled=\"isProcessing\"
            @click=\"modal.open('confirm-modal')\">

            ";
        // line 114
        yield from         $this->loadTemplate("/snippets/spinner.twig", "/templates/admin/update.twig", 114)->unwrap()->yield($context);
        // line 115
        yield "            <span
              x-text=\"isProcessing ? `";
        // line 116
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Installing..."), "html", null, true);
        yield "` : `";
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "Install"), "html", null, true);
        yield "`\"></span>

          </button>
        </template>

        <input type=\"file\" @change=\"file = \$refs.file.files[0]; error = null;\"
          class=\"hidden\"
          accept=\"application/zip, application/x-zip-compressed, multipart/x-zip\"
          x-ref=\"file\">
      </div>
    </section>
  </div>
</div>

<modal-element name=\"confirm-modal\">
  <form class=\"flex flex-col gap-8 modal\" @submit.prevent=\"submit\">
    <div class=\"flex items-center justify-between\">
      <h2 class=\"text-xl\">";
        // line 133
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("heading", "Confirmation"), "html", null, true);
        yield "</h2>

      <button
        class=\"flex items-center justify-center w-8 h-8 border border-transparent rounded-full bg-line-dimmed hover:border-line\"
        @click=\"modal.close()\" type=\"button\">
        <i class=\"text-xl ti ti-x\"></i>
      </button>
    </div>

    <div>
      <div class=\"font-bold\">";
        // line 143
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("audience", "Backup"), "html", null, true);
        yield "</div>
      <div class=\"mt-2 text-sm underline\">
        ";
        // line 145
        yield Twig\Extension\EscaperExtension::escape($this->env, __("It is recommended to backup your data before updating."), "html", null, true);
        yield "
      </div>
    </div>

    <div>
      <div class=\"flex items-center gap-1 text-sm font-bold\">
        <i class=\"text-lg ti ti-info-square-rounded \"></i>
        ";
        // line 152
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Important"), "html", null, true);
        yield "
      </div>

      <p class=\"mt-2 text-sm\">
        ";
        // line 156
        yield Twig\Extension\EscaperExtension::escape($this->env, __("Update might take some time. During this time, the application will be unavailable. Don't close the browser tab or navigate away from this page."), "html", null, true);
        yield "
      </p>
    </div>

    <div class=\"flex items-center\">
      <button class=\"w-full button\" type=\"submit\" :processing=\"isProcessing\">
        ";
        // line 162
        yield from         $this->loadTemplate("/snippets/spinner.twig", "/templates/admin/update.twig", 162)->unwrap()->yield($context);
        // line 163
        yield "
        ";
        // line 164
        yield Twig\Extension\EscaperExtension::escape($this->env, p__("button", "I took a backup, proceed to update"), "html", null, true);
        yield "
      </button>
    </div>
  </form>
</modal-element>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "/templates/admin/update.twig";
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
        return array (  304 => 164,  301 => 163,  299 => 162,  290 => 156,  283 => 152,  273 => 145,  268 => 143,  255 => 133,  233 => 116,  230 => 115,  228 => 114,  215 => 106,  204 => 98,  192 => 89,  156 => 56,  150 => 53,  144 => 50,  138 => 47,  131 => 42,  125 => 39,  122 => 38,  113 => 34,  106 => 30,  99 => 27,  97 => 26,  91 => 23,  84 => 19,  75 => 13,  71 => 11,  69 => 10,  65 => 8,  61 => 7,  53 => 5,  48 => 1,  46 => 4,  44 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/templates/admin/update.twig", "/home/u489518759/domains/renvon.com/resources/views/templates/admin/update.twig");
    }
}
