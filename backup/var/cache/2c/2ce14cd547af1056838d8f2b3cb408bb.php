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

/* snippets/install/failure.twig */
class __TwigTemplate_a0208c7098d742681acfab2a50b5e6c8 extends Template
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
        yield "<div class=\"flex flex-col gap-6 text-center\">
    <div
        class=\"relative flex items-center justify-center mx-auto rounded-full w-28 h-28 text-line-dimmed shrink-0\">

        <svg class=\"absolute top-0 left-0 w-full h-full\" width=\"112\"
            height=\"112\" viewBox=\"0 0 112 112\" fill=\"none\"
            xmlns=\"http://www.w3.org/2000/svg\">
            <circle cx=\"56\" cy=\"56\" r=\"55.5\" stroke=\"currentColor\"
                stroke-dasharray=\"8 8\" />
        </svg>

        <div
            class=\"flex items-center justify-center w-24 h-24 transition-all rounded-full text-content-dimmed bg-line-dimmed\">
            <i class=\"text-5xl ti ti-square-rounded-x-filled text-failure\"></i>
        </div>
    </div>

    <div>
        <div class=\"flex items-center justify-center gap-2\">
            <button type=\"button\"
                @click=\"view(model.migrate ? 'migration' :'account')\"
                class=\"inline-flex items-center gap-1 text-sm rounded-lg text-content-dimmed hover:text-content\"
                :disabled=\"isProcessing\">
                <i class=\"ti ti-square-rounded-arrow-left-filled\"></i>
            </button>

            <h1>Installation is failed</h1>
        </div>

        <p class=\"mt-1 text-intermediate-content\">
            An error occured during the instllation process.
        </p>

        <template x-if=\"error\">
            <p class=\"mt-4 text-sm leading-5 text-failure\" x-text=\"error\">
            </p>
        </template>

        <button type=\"click\" class=\"mt-4 button button-outline\"
            @click=\"error=null; view('welcome')\">
            <i class=\"ti ti-rotate-2\"></i>
            Start over
        </button>
    </div>

</div>";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/install/failure.twig";
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
        return new Source("", "snippets/install/failure.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/install/failure.twig");
    }
}
