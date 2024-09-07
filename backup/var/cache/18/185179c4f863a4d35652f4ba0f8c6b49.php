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

/* snippets/install/db.twig */
class __TwigTemplate_cb0add6cc648a6b744e92e02fe00529c extends Template
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
        yield "<x-form>
    <form class=\"flex flex-col gap-6\" @submit.prevent=\"submitDbForm()\">
        <div class=\"flex items-center gap-2\">
            <button type=\"button\" @click=\"view('license')\"
                :disabled=\"isProcessing\"
                class=\"inline-flex items-center gap-1 text-sm rounded-lg text-content-dimmed hover:text-content\">
                <i class=\"ti ti-square-rounded-arrow-left-filled\"></i>
            </button>

            <h1>Database credential</h1>
        </div>

        <div class=\"grid grid-cols-6 gap-6\">
            <div class=\"col-span-4\">
                <label for=\"host\" class=\"text-sm font-semibold\">Hostname</label>
                <input type=\"text\" class=\"mt-2 input\" id=\"host\"
                    placeholder=\"localhost\" x-model=\"model.db.host\" required>
            </div>

            <div class=\"col-span-2\">
                <label for=\"port\" class=\"text-sm font-semibold\">Port</label>
                <input type=\"text\" class=\"mt-2 input\" id=\"port\"
                    placeholder=\"localhost\" x-model=\"model.db.port\" required>
            </div>

            <div class=\"col-span-6\">
                <label for=\"name\" class=\"text-sm font-semibold\">Database
                    name</label>
                <input type=\"text\" class=\"mt-2 input\" id=\"name\"
                    placeholder=\"aikeedo\" x-model=\"model.db.name\" required>
            </div>

            <div class=\"col-span-3\">
                <label for=\"user\" class=\"text-sm font-semibold\">Username</label>
                <input type=\"text\" class=\"mt-2 input\" id=\"user\"
                    placeholder=\"Your database username\" x-model=\"model.db.user\"
                    required>
            </div>

            <div class=\"col-span-3\">
                <label for=\"password\"
                    class=\"text-sm font-semibold\">Password</label>
                <input type=\"password\" class=\"mt-2 input\" id=\"password\"
                    placeholder=\"Your database password\"
                    autocomplete=\"new-password\" x-model=\"model.db.password\">
            </div>
        </div>

        <template x-if=\"error\">
            <div class=\"text-xs text-failure\" x-text=\"error\">
            </div>
        </template>

        <button type=\"submit\" class=\"w-full button group\"
            :processing=\"isProcessing\">
            Continue
            <i
                class=\"ti ti-square-rounded-arrow-right-filled group-[[processing]]:hidden\"></i>

            <svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\"
                xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\"
                width=\"24px\" height=\"24px\" viewBox=\"0 0 50 50\"
                style=\"enable-background:new 0 0 50 50;\" class=\"spinner\"
                xml:space=\"preserve\">
                <path fill=\"currentColor\"
                    d=\"M25.251,6.461c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615V6.461z\">
                    <animateTransform attributeType=\"xml\"
                        attributeName=\"transform\" type=\"rotate\" from=\"0 25 25\"
                        to=\"360 25 25\" dur=\"0.6s\" repeatCount=\"indefinite\">
                    </animateTransform>
                </path>
            </svg>
        </button>

        <p class=\"flex items-center gap-1 text-xs text-content-dimmed\">
            <i class=\"text-base ti ti-help-square-rounded-filled\"></i>

            <span>
                Don't know hot to setup?

                <a href=\"https://aikeedo.com\" target=\"_blank\"
                    class=\"font-medium text-content hover:underline\">
                    Let us do it for you
                </a>
            </span>
        </p>
    </form>
</x-form>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/install/db.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array ();
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/install/db.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/db.twig");
    }
}
