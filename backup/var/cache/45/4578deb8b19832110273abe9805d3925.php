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

/* snippets/install/requirements.twig */
class __TwigTemplate_51aaf100116abdb37fe037ef3e26dfb2 extends Template
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
        yield "<x-form>
    <form class=\"flex flex-col gap-6\" @submit.prevent=\"view('license')\">
        <div class=\"flex items-center gap-2\">
            <button type=\"button\" @click=\"view('welcome')\"
                :disabled=\"isProcessing\"
                class=\"inline-flex items-center gap-1 text-sm rounded-lg text-content-dimmed hover:text-content\">
                <i class=\"ti ti-square-rounded-arrow-left-filled\"></i>
            </button>

            <h1>Requirements</h1>
        </div>

        <div class=\"flex flex-col gap-4\">
            <div>
                <h2>PHP configuration</h2>
                <p class=\"mt-1 text-sm text-intermediate-content\">
                    Please configure PHP to match following requirements /
                    settings:
                </p>
            </div>

            <table
                class=\"w-full [&_i]:text-2xl [&_td:last-child]:text-right [&_thead_td]:border-b [&_thead_td]:border-line-dimmed text-sm text-intermediate-content\">
                <thead class=\"text-xs text-content-dimmed\">
                    <tr>
                        <td class=\"pb-2\">PHP Settings</td>
                        <td class=\"pb-2\">Required</td>
                        <td class=\"pb-2\">Current</td>
                        <td class=\"pb-2\">&nbsp;</td>
                    </tr>
                </thead>

                <tbody>
                    <template x-for=\"(set, index) in requirements.config\">
                        <tr>
                            <td class=\"font-semibold\" x-text=\"set.name\"
                                :class=\"{'pt-2': index==0}\"></td>
                            <td :class=\"{'pt-2': index==0}\" x-text=\"
                                set.requirement\"></td>
                            <td :class=\"{'pt-2': index==0}\"
                                x-text=\"set.current\">
                                7.4.33</td>

                            <td :class=\"{'pt-2': index==0}\">
                                <template x-if=\"set.is_satisfied\">
                                    <i class=\"ti ti-square-rounded-check-filled\"
                                        :class=\"{'text-success': set.is_required}\"></i>
                                </template>

                                <template x-if=\"!set.is_satisfied\">
                                    <i class=\"ti ti-square-rounded-x-filled\"
                                        :class=\"{'text-failure': set.is_required}\"></i>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <hr class=\"border-line\">

        <div class=\"flex flex-col gap-4\">
            <div>
                <h2>Required PHP extensions</h2>
                <p class=\"mt-1 text-sm text-intermediate-content\">
                    Following PHP extenstions must be installed and enabled:
                </p>
            </div>

            <table
                class=\"w-full [&_i]:text-2xl [&_td:last-child]:text-right [&_thead_td]:border-b [&_thead_td]:border-line-dimmed text-sm text-intermediate-content\">
                <thead class=\"text-xs text-content-dimmed\">
                    <tr>
                        <td class=\"pb-2\">Name</td>
                        <td class=\"pb-2\">Status</td>
                        <td class=\"pb-2\">&nbsp;</td>
                    </tr>
                </thead>

                <tbody>
                    <template x-for=\"(set, index) in requirements.ext\">
                        <template x-if=\"set.is_required\">
                            <tr>
                                <td class=\"font-semibold\"
                                    :class=\"{'pt-2': index==0}\"
                                    x-text=\"set.name\">
                                </td>
                                <td :class=\"{'pt-2': index==0}\"
                                    x-text=\"set.is_satisfied ? 'Installed' : 'Not Installed'\">
                                </td>
                                <td :class=\"{'pt-2': index==0}\">
                                    <template x-if=\"set.is_satisfied\">
                                        <i
                                            class=\"ti ti-square-rounded-check-filled text-success\"></i>
                                    </template>

                                    <template x-if=\"!set.is_satisfied\">
                                        <i
                                            class=\"ti ti-square-rounded-x-filled text-failure\"></i>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>

        <hr class=\"border-line\">

        <div class=\"flex flex-col gap-4\">
            <div>
                <h2>Suggested PHP extensions</h2>
                <p class=\"mt-1 text-sm text-intermediate-content\">
                    Following PHP extensions are suggested, but not required:
                </p>
            </div>

            <table
                class=\"w-full [&_i]:text-2xl [&_td:last-child]:text-right [&_thead_td]:border-b [&_thead_td]:border-line-dimmed text-sm text-intermediate-content\">
                <thead class=\"text-xs text-content-dimmed\">
                    <tr>
                        <td class=\"pb-2\">Name</td>
                        <td class=\"pb-2\">Status</td>
                        <td class=\"pb-2\">&nbsp;</td>
                    </tr>
                </thead>

                <tbody>
                    <template x-for=\"(set, index) in requirements.ext\">
                        <template x-if=\"!set.is_required\">
                            <tr>
                                <td class=\"font-semibold\" x-text=\"set.name\"
                                    :class=\"{'pt-2': index==0}\"></td>
                                <td :class=\"{'pt-2': index==0}\"
                                    x-text=\"set.is_satisfied ? 'Installed' : 'Not Installed'\">
                                </td>
                                <td :class=\"{'pt-2': index==0}\">
                                    <template x-if=\"set.is_satisfied\">
                                        <i
                                            class=\"ti ti-square-rounded-check-filled\"></i>
                                    </template>

                                    <template x-if=\"!set.is_satisfied\">
                                        <i
                                            class=\"ti ti-square-rounded-x-filled\"></i>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>

        <hr class=\"border-line\">

        <div class=\"flex flex-col gap-4\">
            <div>
                <h2>Write permissions</h2>
                <p class=\"mt-1 text-sm text-intermediate-content\">
                    Following files and folders must be writeable by PHP
                </p>
            </div>

            <table
                class=\"w-full [&_i]:text-2xl [&_td:last-child]:text-right [&_thead_td]:border-b [&_thead_td]:border-line-dimmed text-sm text-intermediate-content\">
                <thead class=\"text-xs text-content-dimmed\">
                    <tr>
                        <td class=\"pb-2\">Name</td>
                        <td class=\"pb-2\">Type</td>
                        <td class=\"pb-2\">&nbsp;</td>
                    </tr>
                </thead>

                <tbody>
                    <template x-for=\"(set, index) in requirements.write_access\">
                        <tr>
                            <td class=\"font-semibold\" x-text=\"set.name\"
                                :class=\"{'pt-2': index==0}\"></td>

                            <td :class=\"{'pt-2': index==0}\"
                                x-text=\"set.is_dir ? 'Directory' : 'File'\"></td>

                            <td :class=\"{'pt-2': index==0}\">
                                <template x-if=\"set.is_satisfied\">
                                    <i
                                        class=\"ti ti-square-rounded-check-filled text-success\"></i>
                                </template>

                                <template x-if=\"!set.is_satisfied\">
                                    <i
                                        class=\"ti ti-square-rounded-x-filled text-failure\"></i>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <template x-if=\"requirements.is_satisfied\">
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
                            attributeName=\"transform\" type=\"rotate\"
                            from=\"0 25 25\" to=\"360 25 25\" dur=\"0.6s\"
                            repeatCount=\"indefinite\">
                        </animateTransform>
                    </path>
                </svg>
            </button>
        </template>

        <template x-if=\"!requirements.is_satisfied\">
            <button type=\"button\" class=\"w-full button button-dimmed group\"
                :processing=\"isProcessing\" @click=\"viewRequirement()\">

                <i class=\"ti ti-reload group-[[processing]]:hidden\"></i>

                ";
        // line 234
        yield from         $this->loadTemplate("snippets/spinner.twig", "snippets/install/requirements.twig", 234)->unwrap()->yield($context);
        // line 235
        yield "
                Check again
            </button>
        </template>
    </form>
</x-form>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/install/requirements.twig";
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
        return array (  275 => 235,  273 => 234,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/install/requirements.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/requirements.twig");
    }
}
