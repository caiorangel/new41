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

/* snippets/install/license.twig */
class __TwigTemplate_9c595e681b3fc05e53c4992f15dc5083 extends Template
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
    <form class=\"flex flex-col gap-6\" @submit.prevent=\"submitLicenseForm()\">
        <div class=\"flex items-center gap-2\">
            <button type=\"button\" @click=\"view('requirements');\"
                class=\"inline-flex items-center gap-1 text-sm rounded-lg text-content-dimmed hover:text-content\">
                <i class=\"ti ti-square-rounded-arrow-left-filled\"></i>
            </button>

            <h1>License</h1>
        </div>

        <div>
            <label for=\"license\" class=\"text-sm font-semibold\">Purchase
                code</label>
            <input type=\"text\" class=\"mt-2 input\" id=\"license\" required
                x-model=\"model.license\">

            <template x-if=\"error\">
                <ul class=\"m-3 mb-0 text-xs list-disc list-inside text-failure\">
                    <li class=\"my-1\" x-text=\"error\"></li>
                </ul>
            </template>
        </div>

        <button type=\"submit\" class=\"w-full button group\"
            :processing=\"isProcessing\">
            Continue
            <i
                class=\"ti square-rounded-arrow-right-filled group-[[processing]]:hidden\"></i>

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

            <a href=\"https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-\"
                target=\"_blank\"
                class=\"font-medium text-content hover:underline\">
                Where is my purchase code?
            </a>
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
        return "snippets/install/license.twig";
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
        return new Source("", "snippets/install/license.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/license.twig");
    }
}
