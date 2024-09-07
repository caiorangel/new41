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

/* snippets/script-tags/head.twig */
class __TwigTemplate_375c20ff8fab400fadb601d7618df5b8 extends Template
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
        if ((((($context["view_namespace"] ?? null) != "admin") && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 1), "custom", [], "any", false, true, false, 1), "head", [], "any", true, true, false, 1)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 1), "custom", [], "any", false, false, false, 1), "head", [], "any", false, false, false, 1))) {
            // line 2
            yield Twig\Extension\CoreExtension::include($this->env, $context, $this->env->getFunction('template')->getCallable()($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 2), "custom", [], "any", false, false, false, 2), "head", [], "any", false, false, false, 2)));
            yield "
";
        }
        // line 4
        yield "
";
        // line 5
        if ((((((($context["view_namespace"] ?? null) != "admin") && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 5), "gtm", [], "any", true, true, false, 5)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 5), "gtm", [], "any", false, false, false, 5), "is_enabled", [], "any", false, false, false, 5)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 5), "gtm", [], "any", false, true, false, 5), "container_id", [], "any", true, true, false, 5)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 5), "gtm", [], "any", false, false, false, 5), "container_id", [], "any", false, false, false, 5))) {
            // line 6
            yield "<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','";
            // line 11
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 11), "gtm", [], "any", false, false, false, 11), "container_id", [], "any", false, false, false, 11), "html", null, true);
            yield "');</script>
  <!-- End Google Tag Manager -->
";
        }
        // line 14
        yield "
";
        // line 15
        if ((((((($context["view_namespace"] ?? null) != "admin") && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 15), "ga", [], "any", false, true, false, 15), "is_enabled", [], "any", true, true, false, 15)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 15), "ga", [], "any", false, false, false, 15), "is_enabled", [], "any", false, false, false, 15)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 15), "ga", [], "any", false, true, false, 15), "measurement_id", [], "any", true, true, false, 15)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 15), "ga", [], "any", false, false, false, 15), "measurement_id", [], "any", false, false, false, 15))) {
            // line 16
            yield "<!-- Google tag (gtag.js) -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=";
            // line 17
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 17), "ga", [], "any", false, false, false, 17), "measurement_id", [], "any", false, false, false, 17), "html", null, true);
            yield "\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() { dataLayer.push(arguments); }
  gtag('js', new Date());

  gtag('config', '";
            // line 23
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 23), "ga", [], "any", false, false, false, 23), "measurement_id", [], "any", false, false, false, 23), "html", null, true);
            yield "');
</script>
";
        }
        // line 26
        yield "
";
        // line 27
        if ((((((($context["view_namespace"] ?? null) != "admin") && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 27), "intercom", [], "any", false, true, false, 27), "is_enabled", [], "any", true, true, false, 27)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 27), "intercom", [], "any", false, false, false, 27), "is_enabled", [], "any", false, false, false, 27)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 27), "intercom", [], "any", false, true, false, 27), "app_id", [], "any", true, true, false, 27)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 27), "intercom", [], "any", false, false, false, 27), "app_id", [], "any", false, false, false, 27))) {
            // line 28
            yield "<script>
  window.intercomSettings = {
    api_base: \"https://api-iam.intercom.io\",
    app_id: \"";
            // line 31
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 31), "intercom", [], "any", false, false, false, 31), "app_id", [], "any", false, false, false, 31), "html", null, true);
            yield "\",

    ";
            // line 33
            if (array_key_exists("user", $context)) {
                // line 34
                yield "    name: `";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "first_name", [], "any", false, false, false, 34), "html", null, true);
                yield " ";
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "last_name", [], "any", false, false, false, 34), "html", null, true);
                yield "`, 
    user_id: `";
                // line 35
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", false, false, false, 35), "html", null, true);
                yield "`,
    email: `";
                // line 36
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "email", [], "any", false, false, false, 36), "html", null, true);
                yield "`,
    created_at: ";
                // line 37
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "created_at", [], "any", false, false, false, 37), "html", null, true);
                yield ",
    company: {
      id: `";
                // line 39
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["workspace"] ?? null), "id", [], "any", false, false, false, 39), "html", null, true);
                yield "`,
      name: `";
                // line 40
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["workspace"] ?? null), "name", [], "any", false, false, false, 40), "html", null, true);
                yield "`,
      created_at: ";
                // line 41
                yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["workspace"] ?? null), "created_at", [], "any", false, false, false, 41), "html", null, true);
                yield ",
      ";
                // line 42
                if (CoreExtension::getAttribute($this->env, $this->source, ($context["workspace"] ?? null), "subscription", [], "any", false, false, false, 42)) {
                    // line 43
                    yield "      plan: `";
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["workspace"] ?? null), "subscription", [], "any", false, false, false, 43), "plan", [], "any", false, false, false, 43), "title", [], "any", false, false, false, 43), "html", null, true);
                    yield "`,
      ";
                }
                // line 45
                yield "    },
    companies: [
      ";
                // line 47
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(Twig\Extension\CoreExtension::arrayMerge(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "owned_workspaces", [], "any", false, false, false, 47), CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "workspaces", [], "any", false, false, false, 47)));
                foreach ($context['_seq'] as $context["_key"] => $context["ws"]) {
                    // line 48
                    yield "      {
        id: `";
                    // line 49
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["ws"], "id", [], "any", false, false, false, 49), "html", null, true);
                    yield "`,
        name: `";
                    // line 50
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["ws"], "name", [], "any", false, false, false, 50), "html", null, true);
                    yield "`,
        created_at: ";
                    // line 51
                    yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["ws"], "created_at", [], "any", false, false, false, 51), "html", null, true);
                    yield ",
      },  
      ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ws'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 54
                yield "    ],
    
    ";
                // line 56
                if ((((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 56), "intercom", [], "any", false, true, false, 56), "verification_is_enabled", [], "any", true, true, false, 56) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 56), "intercom", [], "any", false, false, false, 56), "verification_is_enabled", [], "any", false, false, false, 56)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, true, false, 56), "intercom", [], "any", false, true, false, 56), "secret_key", [], "any", true, true, false, 56)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 56), "intercom", [], "any", false, false, false, 56), "secret_key", [], "any", false, false, false, 56))) {
                    // line 57
                    yield "    user_hash: \"";
                    yield Twig\Extension\EscaperExtension::escape($this->env, hash_hmac("sha256", CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", false, false, false, 57), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 57), "intercom", [], "any", false, false, false, 57), "secret_key", [], "any", false, false, false, 57)), "html", null, true);
                    yield "\",
    ";
                }
                // line 59
                yield "    ";
            }
            // line 60
            yield "
  };
</script>

<script>
(function(){var w=window;var ic=w.Intercom;if(typeof ic===\"function\"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/";
            // line 65
            yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "script_tags", [], "any", false, false, false, 65), "intercom", [], "any", false, false, false, 65), "app_id", [], "any", false, false, false, 65), "html", null, true);
            yield "';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
";
        }
        // line 68
        yield "
";
        // line 69
        if ((((($context["view_namespace"] ?? null) != "admin") && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "onesignal", [], "any", false, true, false, 69), "is_enabled", [], "any", true, true, false, 69)) && CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "onesignal", [], "any", false, false, false, 69), "is_enabled", [], "any", false, false, false, 69))) {
            // line 70
            yield "  <script src=\"https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js\"
    defer></script>

  <script>
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(async function (OneSignal) {
      await OneSignal.init({
        appId: `";
            // line 77
            (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "onesignal", [], "any", false, true, false, 77), "app_id", [], "any", true, true, false, 77) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "onesignal", [], "any", false, true, false, 77), "app_id", [], "any", false, false, false, 77)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["option"] ?? null), "onesignal", [], "any", false, true, false, 77), "app_id", [], "any", false, false, false, 77), "html", null, true)) : (yield ""));
            yield "`,
        serviceWorkerParam: { scope: \"/push/onesignal/\" },
        serviceWorkerPath: \"push/onesignal/OneSignalSDKWorker.js\"
      });

      let userId = `";
            // line 82
            (((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", true, true, false, 82) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", false, false, false, 82)))) ? (yield Twig\Extension\EscaperExtension::escape($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "id", [], "any", false, false, false, 82), "html", null, true)) : (yield ""));
            yield "`;
      if (userId != '') {
        await OneSignal.login(userId);
      } else {
        await OneSignal.logout();
      }

      let permission = await OneSignal.Notifications.permission;

      if (Notification.permission === 'default' && !permission) {
        // Request notification permission
        Notification.requestPermission();
      }
    });
  </script>
  ";
        }
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "snippets/script-tags/head.twig";
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
        return array (  221 => 82,  213 => 77,  204 => 70,  202 => 69,  199 => 68,  193 => 65,  186 => 60,  183 => 59,  177 => 57,  175 => 56,  171 => 54,  162 => 51,  158 => 50,  154 => 49,  151 => 48,  147 => 47,  143 => 45,  137 => 43,  135 => 42,  131 => 41,  127 => 40,  123 => 39,  118 => 37,  114 => 36,  110 => 35,  103 => 34,  101 => 33,  96 => 31,  91 => 28,  89 => 27,  86 => 26,  80 => 23,  71 => 17,  68 => 16,  66 => 15,  63 => 14,  57 => 11,  50 => 6,  48 => 5,  45 => 4,  40 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "snippets/script-tags/head.twig", "/home/u489518759/domains/renvon.com/resources/views/snippets/script-tags/head.twig");
    }
}
