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

/* snippets/install/account.twig */
class __TwigTemplate_10f3c90ac47a9396cff04eb4b4c4d36e extends Template
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
    <form class=\"flex flex-col gap-6\" @submit.prevent=\"install()\">
        <div class=\"flex items-center gap-2\">
            <button type=\"button\" @click=\"view('db')\" :disabled=\"isProcessing\"
                class=\"inline-flex items-center gap-1 text-sm rounded-lg text-content-dimmed hover:text-content\">
                <i class=\"ti ti-square-rounded-arrow-left-filled\"></i>
            </button>

            <h1>Account details</h1>
        </div>

        <div class=\"grid grid-cols-2 gap-6\">
            <div>
                <label for=\"first-namet\" class=\"text-sm font-semibold\">First
                    name</label>
                <input type=\"text\" class=\"mt-2 input\" id=\"first-namet\"
                    placeholder=\"Type your first name\" required
                    x-model=\"model.account.first_name\">
            </div>

            <div>
                <label for=\"last-namet\" class=\"text-sm font-semibold\">Last
                    name</label>
                <input type=\"text\" class=\"mt-2 input\" id=\"last-namet\"
                    placeholder=\"Type your last name\" required
                    x-model=\"model.account.last_name\">
            </div>

            <div>
                <label for=\"email\" class=\"text-sm font-semibold\">Email</label>
                <input type=\"email\" class=\"mt-2 input\" id=\"email\"
                    placeholder=\"Type your email\" required
                    x-model=\"model.account.email\">
            </div>

            <div>
                <label for=\"password\"
                    class=\"text-sm font-semibold\">Password</label>
                <input type=\"password\" class=\"mt-2 input\" id=\"password\"
                    placeholder=\"Type your password\" autocomplete=\"new-password\"
                    required x-model=\"model.account.password\">
            </div>
        </div>

        <template x-if=\"error\">
            <div class=\"text-xs text-failure\" x-text=\"error\">
            </div>
        </template>

        <div>
            <button type=\"submit\" class=\"w-full button group\"
                :processing=\"isProcessing\">
                Finish installation
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

            <template x-if=\"model.migrate === false && model.hasData\">
                <p class=\"mt-4 text-xs text-center text-content-dimmed\">
                    This will delete all existing data in the <strong
                        x-text=\"model.db.name\" class=\"text-content\"></strong>
                    database.
                </p>
            </template>
        </div>
    </form>
</x-form>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/install/account.twig";
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
        return new Source("", "snippets/install/account.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/account.twig");
    }
}
